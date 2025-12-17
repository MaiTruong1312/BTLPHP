<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\InterviewEvaluation;
use Illuminate\Http\Request;

class InterviewEvaluationController extends Controller
{
    public function store(Request $request, Interview $interview)
    {
        if ($interview->interviewer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'strengths' => 'nullable|string|max:2000',
            'weaknesses' => 'nullable|string|max:2000',
            'overall_comment' => 'required|string|max:5000',
        ]);

        InterviewEvaluation::updateOrCreate(
            ['interview_id' => $interview->id],
            [
                'evaluator_id' => auth()->id(),
                ...$validated
            ]
        );

        return back()->with('success', 'Candidate evaluation saved successfully!');
    }
}
