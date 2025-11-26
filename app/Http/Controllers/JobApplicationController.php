<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:candidate');
    // }

    public function store(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);
        $request->validate([
            'cover_letter' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Check if already applied
        if ($job->applications()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        } elseif (auth()->user()->candidateProfile && auth()->user()->candidateProfile->cv_path) {
            $cvPath = auth()->user()->candidateProfile->cv_path;
        }

        JobApplication::create([
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'candidate_profile_id' => auth()->user()->candidateProfile?->id,
            'cover_letter' => $request->cover_letter,
            'cv_path' => $cvPath,
            'status' => 'applied',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    public function index(Request $request)
    {
        $query = JobApplication::with(['job', 'job.category', 'job.location'])
            ->where('user_id', auth()->id())
            ->latest('applied_at');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = JobApplication::findOrFail($id);
        $this->authorize('view', $application);

        $application->load(['job', 'job.category', 'job.location', 'job.employerProfile']);

        return view('applications.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);
        $this->authorize('update', $application);

        $request->validate([
            'status' => 'required|in:reviewing,interview,offered,rejected,withdrawn',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated successfully!');
    }

    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $this->authorize('delete', $application);

        $application->delete();

        return back()->with('success', 'Application withdrawn successfully!');
    }
}

