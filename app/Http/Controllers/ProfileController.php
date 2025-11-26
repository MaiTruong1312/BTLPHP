<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\EmployerProfile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $skills = \App\Models\Skill::all(); // Lấy danh sách kỹ năng để hiển thị
        
        if ($user->isCandidate()) {
            $user->load('candidateProfile.skills', 'candidateProfile.experiences', 'candidateProfile.educations');
            return view('profile.candidate', compact('user', 'skills'));
        } elseif ($user->isEmployer()) {
            $user->load('employerProfile');
            return view('profile.employer', compact('user'));
        }

        return redirect()->route('dashboard');
    }

    public function showPublic(User $user)
    {
        if (!$user->isCandidate() || !$user->candidateProfile) {
            abort(404, 'Candidate profile not found.');
        }

        // Tải các mối quan hệ cần thiết để hiển thị
        $user->load(
            'candidateProfile.skills',
            'candidateProfile.experiences',
            'candidateProfile.educations'
        );

        return view('profile.public', compact('user'));
    }

    public function updateCandidate(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isCandidate()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'years_of_experience' => 'nullable|integer|min:0',
            'expected_salary_min' => 'nullable|integer|min:0',
            'expected_salary_max' => 'nullable|integer|min:0|gte:expected_salary_min',
            'skills' => 'nullable|array',
            'skills.*' => 'string', // Chấp nhận cả ID (dạng chuỗi) và tên kỹ năng mới
        ]);

        $user->update(['name' => $validated['name']]);

        $profile = $user->candidateProfile ?? CandidateProfile::create(['user_id' => $user->id]);

        if ($request->hasFile('cv')) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        // Cập nhật kỹ năng
        if (isset($validated['skills'])) {
            $skillIds = [];
            foreach ($validated['skills'] as $skillNameOrId) {
                if (is_numeric($skillNameOrId)) {
                    // Nếu là ID số, thêm trực tiếp
                    $skillIds[] = $skillNameOrId;
                } else {
                    // Nếu là tên kỹ năng mới, tìm hoặc tạo mới
                    $newSkill = \App\Models\Skill::firstOrCreate(
                        ['name' => $skillNameOrId],
                        ['slug' => \Illuminate\Support\Str::slug($skillNameOrId)]
                    );
                    $skillIds[] = $newSkill->id;
                }
            }
            $profile->skills()->sync($skillIds);
        } else {
            $profile->skills()->sync([]); // Xóa tất cả kỹ năng nếu không có gì được chọn
        }

        unset($validated['name'], $validated['cv'], $validated['skills']);
        $profile->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateEmployer(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isEmployer()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,501-1000,1000+',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $user->update(['name' => $validated['name']]);

        $profile = $user->employerProfile ?? EmployerProfile::create([
            'user_id' => $user->id,
            'company_name' => $validated['company_name'],
            'company_slug' => \Illuminate\Support\Str::slug($validated['company_name']),
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        unset($validated['name']);
        $profile->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    // Quản lý Kinh nghiệm
    public function storeExperience(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        auth()->user()->candidateProfile->experiences()->create($request->all());

        return back()->with('success', 'Experience added successfully!');
    }

    public function updateExperience(Request $request, \App\Models\CandidateExperience $experience)
    {
        // Đảm bảo kinh nghiệm này thuộc về người dùng đang đăng nhập
        if ($experience->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        // Xử lý checkbox 'is_current'
        $validated['is_current'] = $request->has('is_current');

        $experience->update($validated);

        return back()->with('success', 'Experience updated successfully!');
    }

    public function destroyExperience($experienceId)
    {
        $experience = \App\Models\CandidateExperience::findOrFail($experienceId);
        // Đảm bảo kinh nghiệm này thuộc về người dùng đang đăng nhập
        if ($experience->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }
        $experience->delete();

        return back()->with('success', 'Experience removed successfully!');
    }

    // Quản lý Học vấn
    public function storeEducation(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        auth()->user()->candidateProfile->educations()->create($request->all());

        return back()->with('success', 'Education added successfully!');
    }

    public function updateEducation(Request $request, \App\Models\CandidateEducation $education)
    {
        // Đảm bảo học vấn này thuộc về người dùng đang đăng nhập
        if ($education->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $education->update($validated);

        return back()->with('success', 'Education updated successfully!');
    }

    public function destroyEducation($educationId)
    {
        $education = \App\Models\CandidateEducation::findOrFail($educationId);
        // Đảm bảo học vấn này thuộc về người dùng đang đăng nhập
        if ($education->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }
        $education->delete();

        return back()->with('success', 'Education removed successfully!');
    }

    /**
     * Cập nhật ảnh đại diện của người dùng.
     */
    public function updateAvatar(Request $request)
    {
        $user = auth()->user();
        $path = null;

        if ($request->has('avatar_base64') && !empty($request->input('avatar_base64'))) {
            $request->validate([
                'avatar_base64' => 'required|string',
            ]);

            $data = $request->input('avatar_base64');
            @list($type, $data) = explode(';', $data);
            @list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $fileName = 'avatars/' . uniqid() . '.jpg';
            Storage::disk('public')->put($fileName, $data);
            $path = $fileName;

        } elseif ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            // Lưu avatar mới nếu người dùng không cắt ảnh
            $path = $request->file('avatar')->store('avatars', 'public');
        }

        if ($path) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Cập nhật CSDL
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Avatar updated successfully!');
    }
}
