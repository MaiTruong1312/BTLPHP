<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the user's applications.
     */
    public function index()
    {
        $applications = JobApplication::with(['job.employerProfile', 'job.user', 'job.location'])
            ->where('user_id', Auth::id())
            ->latest('applied_at')
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    /**
     * Display the specified application.
     */
    public function show($id)
    {
        // Ensure the application belongs to the logged-in user
        $application = JobApplication::with(['job.employerProfile', 'job.user', 'user', 'candidateProfile', 'interview'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('applications.show', compact('application'));
    }

    /**
     * Withdraw/Delete an application.
     */
    public function destroy($id)
    {
        $application = JobApplication::where('user_id', Auth::id())->findOrFail($id);
        $application->delete();

        return back()->with('success', 'Application withdrawn successfully.');
    }
}
