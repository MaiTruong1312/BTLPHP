<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        $currentPlanId = null;

        $user = Auth::user();
        if ($user && $user->isEmployer() && $user->employerProfile && $user->employerProfile->subscription) {
            $currentPlanId = $user->employerProfile->subscription->plan_id;
        }

        return view('pricing.index', compact('plans', 'currentPlanId'));
    }
}
