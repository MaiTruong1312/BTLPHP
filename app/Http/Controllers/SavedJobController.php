<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:candidate');
    // }

    public function index()
    {
        $jobs = auth()->user()->savedJobs()->with(['category', 'location', 'employerProfile'])->paginate(12);

        return view('saved-jobs.index', compact('jobs'));
    }

    public function store($jobId)
    {
        $job = Job::findOrFail($jobId);
        if (auth()->user()->savedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Job already saved.');
        }

        auth()->user()->savedJobs()->attach($job->id);

        return back()->with('success', 'Job saved successfully!');
    }

    public function destroy($jobId)
    {
        $job = Job::findOrFail($jobId);
        auth()->user()->savedJobs()->detach($job->id);

        return back()->with('success', 'Job removed from saved list.');
    }
}

