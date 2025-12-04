<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertJobRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        $job = Job::with(['category', 'location', 'employerProfile', 'skills', 'user']) // Bỏ eager load comments ở đây
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $job->increment('views_count');
 
        // Lấy các bình luận gốc và phân trang chúng
        // Eager load user và các bình luận trả lời (replies) cho mỗi bình luận
        $comments = $job->comments()
            ->with([
                'user',
                'replies' => function ($query) {
                    $query->with('user')->latest();
                }
            ])
            ->withCount('replies')
            ->latest()
            ->paginate(5, ['*'], 'page');

        $isSaved = auth()->check() && auth()->user()->savedJobs()->where('job_id', $job->id)->exists();
        $hasApplied = auth()->check() && auth()->user()->applications()->where('job_id', $job->id)->exists();
 
        return view('jobs.show', compact('job', 'isSaved', 'hasApplied', 'comments'));
    }

    public function create()
    {
        // First, check for authorization
        if (Gate::denies('create', Job::class)) {
            $user = auth()->user();

            // Check if the user has an employer profile
            if (!$user->employerProfile) {
                return redirect()->route('employer.profile.create')
                    ->with('error', 'Please create your company profile before posting a job.');
            }

            // Check for active subscriptions
            $activeSubscriptions = $user->employerProfile->subscriptions()
                ->where(function ($query) {
                    $query->where('ends_at', '>', now())->orWhereNull('ends_at');
                })->exists();

            if (!$activeSubscriptions) {
                return redirect()->route('pricing')
                    ->with('error', 'You need an active subscription to post a job. Please choose a plan.');
            }

            // If they have a subscription, they must have hit their limit
            return redirect()->back()
                ->with('error', 'You have reached the maximum number of job postings allowed by your current plan.');
        }
        
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
        $validated['status'] = 'pending_approval'; // All new jobs require admin approval

        if (auth()->user()->employerProfile) {
            $validated['employer_profile_id'] = auth()->user()->employerProfile->id;
        }

        $job = Job::create($validated);

        if ($request->has('skills')) {
            $job->skills()->attach($request->skills);
        }

        return redirect()->route('dashboard')->with('success', 'Job submitted for approval successfully!');
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

        $employer = auth()->user();
        $templates = $employer->emailTemplates()->get();
        
        // Lấy danh sách công việc của nhà tuyển dụng để hiển thị trong bộ lọc
        $jobs = Job::where('user_id', $employer->id)->orderBy('title')->get();

        return view('employer.index', compact('job', 'applications', 'templates', 'jobs'));
    }
}
