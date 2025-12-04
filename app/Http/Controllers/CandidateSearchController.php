<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\Skill;
use Illuminate\Http\Request;

class CandidateSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CandidateProfile::where('is_searchable', true)
            ->with('user', 'skills', 'educations', 'experiences');

        // Search by keyword in summary or user name
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('summary', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        // Filter by skills
        if ($request->filled('skills')) {
            $skillIds = $request->skills;
            $query->whereHas('skills', function ($q) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            }, '=', count($skillIds));
        }

        $candidates = $query->latest()->paginate(12);
        $skills = Skill::orderBy('name')->get();

        return view('candidates.search', compact('candidates', 'skills'));
    }
}
