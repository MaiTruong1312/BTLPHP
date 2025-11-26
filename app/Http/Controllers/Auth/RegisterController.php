<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\EmployerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:candidate,employer'],
            'company_name' => ['nullable', 'string', 'max:191'],
        ]);

        $validator->sometimes('company_name', 'required', function ($input) {
            return $input->role === 'employer';
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);

                if ($request->role === 'candidate') {
                    CandidateProfile::create(['user_id' => $user->id]);
                } else {
                    $companyName = $request->company_name ?? 'Company '.$user->id;
                    $slugBase = Str::slug($companyName);
                    $slug = $slugBase;
                    $counter = 1;
                    while (EmployerProfile::where('company_slug', $slug)->exists()) {
                        $slug = $slugBase.'-'.$counter++;
                    }

                    EmployerProfile::create([
                        'user_id' => $user->id,
                        'company_name' => $companyName,
                        'company_slug' => $slug,
                    ]);
                }

                return $user;
            });
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            throw $e;
        }

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to Job Portal!');
    }
}

