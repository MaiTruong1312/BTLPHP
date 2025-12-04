<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isCandidate()) {
            $applications = $user->applications()->with('job')->latest()->take(5)->get();
            $savedJobs = $user->savedJobs()->latest()->take(5)->get();
            $suggestedJobs = collect();

            if ($user->candidateProfile) {
                $skillIds = $user->candidateProfile->skills()->pluck('skills.id');
                if ($skillIds->isNotEmpty()) {
                    $suggestedJobs = Job::with(['category', 'location', 'employerProfile'])
                        ->active()
                        ->whereHas('skills', function ($query) use ($skillIds) {
                            $query->whereIn('skills.id', $skillIds);
                        })
                        // Loại bỏ các công việc đã ứng tuyển
                        ->whereNotIn('id', $user->applications()->pluck('job_id'))
                        ->latest()
                        ->take(5)
                        ->get();
                }
            }
            $applicationStats = $user->applications()
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');

            $statuses = ['applied', 'reviewing', 'interview', 'offered', 'rejected', 'withdrawn'];
            $chartLabels = [];
            $chartData = [];

            foreach ($statuses as $status) {
                $chartLabels[] = ucfirst($status);
                $chartData[] = $applicationStats->get($status, 0);
            }
            
            return view('dashboard.candidate', compact('applications', 'savedJobs', 'suggestedJobs', 'chartLabels', 'chartData'));
        } elseif ($user->isEmployer()) {
            $employerJobsQuery = $user->jobs(); 
            $jobIds = (clone $employerJobsQuery)->pluck('id');
            $totalJobs = $jobIds->count();
            $totalApplications = \App\Models\JobApplication::whereIn('job_id', $jobIds)->count();
            $period = in_array($request->input('period'), ['7', '30', '90']) ? $request->input('period') : '30';
            $days = (int)$period;
            $applicationStats = \App\Models\JobApplication::whereIn('job_id', $jobIds)
                ->where('created_at', '>=', now()->subDays($days))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get([
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('count(*) as count')
                ])
                ->pluck('count', 'date');
            $chartLabels = [];
            $chartData = [];
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $chartLabels[] = now()->subDays($i)->format('M d'); 
                $chartData[] = $applicationStats->get($date, 0);
            }

            $jobs = $employerJobsQuery->with(['category', 'location'])->latest()->paginate(10);
            
            return view('dashboard.employer', compact('jobs', 'totalApplications', 'totalJobs', 'chartLabels', 'chartData', 'period'));
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}
