<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Skill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['category', 'location', 'employerProfile'])
            ->active()
            ->latest();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by location
        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }

        // Filter by job type
        if ($request->has('job_type') && $request->job_type) {
            $query->where('job_type', $request->job_type);
        }

        // Filter by skills
        if ($request->has('skills') && !empty($request->skills)) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->whereIn('skills.id', $request->skills);
            });
        }

        $jobs = $query->paginate(12);
        $categories = JobCategory::all();
        $locations = JobLocation::all();
        $skills = Skill::all();
        return view('home', compact('jobs', 'categories', 'locations', 'skills'));
    }
}
