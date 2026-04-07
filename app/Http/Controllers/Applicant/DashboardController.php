<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show applicant dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $application = $user->jobApplications()->first();

        return view('applicant.dashboard', compact('user', 'application'));
    }
}
