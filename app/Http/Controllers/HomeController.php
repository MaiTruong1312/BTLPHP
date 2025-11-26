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

        // Filter by salary range
        if ($request->filled('salary_range')) {
            $salaryRange = $request->salary_range;
            if ($salaryRange === 'negotiable') {
                // Find jobs where salary type is negotiable or both min and max are null
                $query->where(function ($q) {
                    $q->where('salary_type', 'negotiable')
                      ->orWhere(function ($sub) {
                          $sub->whereNull('salary_min')->whereNull('salary_max');
                      });
                });
            } elseif (is_numeric($salaryRange)) {
                // Logic mới: Tìm các công việc có khoảng lương mà điểm cuối của nó (salary_max)
                // lớn hơn hoặc bằng mốc lương người dùng chọn.
                // Điều này đảm bảo khi chọn "Trên 5 triệu" thì các công việc "10-15 triệu" cũng sẽ hiện ra.
                $query->where(function ($q) use ($salaryRange) {
                    $q->where('salary_max', '>=', (int)$salaryRange) // Lương tối đa >= mốc đã chọn
                      ->orWhereNull('salary_max'); // Hoặc các công việc không có lương tối đa (ví dụ: "Từ 10 triệu" hoặc "Thương lượng")
                });
            }
        }

        $jobs = $query->paginate(12);
        $categories = JobCategory::all();
        $locations = JobLocation::all();
        $skills = Skill::all();
        return view('home', compact('jobs', 'categories', 'locations', 'skills'));
    }
}
