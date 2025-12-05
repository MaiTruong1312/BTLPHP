<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Skill;
use App\Models\EmployerProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['category', 'location', 'employerProfile'])
            ->where('status', 'published') 
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
        if ($request->filled('salary_range')) {
            $salaryRange = $request->salary_range;
            if ($salaryRange === 'negotiable') {
                $query->where(function ($q) {
                    $q->where('salary_type', 'negotiable')
                      ->orWhere(function ($sub) {
                          $sub->whereNull('salary_min')->whereNull('salary_max');
                      });
                });
            } elseif (is_numeric($salaryRange)) {
                $query->where(function ($q) use ($salaryRange) {
                    $q->where('salary_max', '>=', (int)$salaryRange)
                      ->orWhereNull('salary_max'); 
                });
            }
        }

        $jobs = $query->paginate(9)->withQueryString(); 
        $stats = [
            'jobs_count' => Job::where('status', 'published')->count(),
            'companies_count' => EmployerProfile::count(),
            'jobs_today_count' => Job::where('status', 'published')->whereDate('created_at', Carbon::today())->count(),
        ];
        $featuredCompanies = EmployerProfile::whereNotNull('logo')->latest()->take(5)->get();
        $popularCategories = JobCategory::take(5)->get();
        $categories = JobCategory::all();
        $locations = JobLocation::all();
        $skills = Skill::all();
        return view('home', compact('jobs', 'categories', 'locations', 'skills', 'stats', 'featuredCompanies', 'popularCategories'));
    }
}
