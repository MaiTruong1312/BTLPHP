<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertJobRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['category', 'location', 'employerProfile'])
            ->active()
            ->latest();

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }

        // Salary range filtering
        if ($request->filled('min_salary') || $request->filled('max_salary')) {
            $query->where(function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    if ($request->filled('min_salary')) {
                        $subQuery->where(function($orQuery) use ($request) {
                            $orQuery->where('salary_max', '>=', $request->min_salary)
                                    ->orWhereNull('salary_max');
                        });
                    }
                    if ($request->filled('max_salary')) {
                        $subQuery->where('salary_min', '<=', $request->max_salary);
                    }
                })->orWhere('salary_type', 'negotiable');
            });
        }

        $jobs = $query->paginate(12);
        $categories = JobCategory::all();
        $locations = JobLocation::all();

        return view('jobs.index', compact('jobs', 'categories', 'locations'));
    }

    public function show($slug)
    {
        $job = Job::with(['category', 'location', 'employerProfile', 'skills', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $job->increment('views_count');

        $isSaved = auth()->check() && auth()->user()->savedJobs()->where('job_id', $job->id)->exists();
        $hasApplied = auth()->check() && auth()->user()->applications()->where('job_id', $job->id)->exists();

        return view('jobs.show', compact('job', 'isSaved', 'hasApplied'));
    }

    public function create()
    {
        // Lấy dữ liệu cần thiết cho các dropdown trong form
        $categories = JobCategory::orderBy('name')->get();
        $locations = JobLocation::orderBy('city')->get();
        $skills = Skill::orderBy('name')->get();

        return view('jobs.create', compact('categories', 'locations', 'skills'));
    }

    public function store(UpsertJobRequest $request)
    {
        // Authorization and validation are handled by UpsertJobRequest

        $validated = $request->validated();

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['is_remote'] = $request->has('is_remote');
        $validated['status'] = $validated['status'] ?? 'published';

        if (auth()->user()->employerProfile) {
            $validated['employer_profile_id'] = auth()->user()->employerProfile->id;
        }

        $job = Job::create($validated);

        if ($request->has('skills')) {
            $job->skills()->attach($request->skills);
        }

        return redirect()->route('jobs.show', $job->slug)->with('success', 'Job posted successfully!');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job);

        $categories = JobCategory::all();
        $locations = JobLocation::all();
        $skills = Skill::all();
        $job->load('skills');

        return view('jobs.edit', compact('job', 'categories', 'locations', 'skills'));
    }

    public function update(UpsertJobRequest $request, $id)
    {
        $job = Job::findOrFail($id);
        // Authorization is handled by UpsertJobRequest
        // We still need to find the job to update it.

        $validated = $request->validated();

        $validated['is_remote'] = $request->has('is_remote');

        $job->update($validated);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        } else {
            $job->skills()->detach();
        }

        return redirect()->route('jobs.show', $job->slug)->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }

    public function showApplicants($id)
    {
        $job = Job::findOrFail($id);

        // Authorize that the current user can view applicants for this job
        // This assumes you have an 'update' policy on the Job model that checks ownership.
        $this->authorize('update', $job);

        // Load applications with candidate profile and user information
        $applications = $job->applications()
                            ->with(['user', 'candidateProfile'])
                            ->paginate(15);

        return view('jobs.applicants', compact('job', 'applications'));
    }
}
