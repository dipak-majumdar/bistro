<?php

namespace App\Http\Controllers\UserPortal;

use App\Http\Controllers\Controller;
use App\Models\UserLoginActivity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginActivityController extends Controller
{
    /**
     * Display user login activities.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $query = $user->loginActivities()
            ->with('user')
            ->orderBy('login_at', 'desc');
        
        // Filter by period
        if ($request->filled('period')) {
            $period = $request->get('period');
            $days = match($period) {
                '7' => 7,
                '30' => 30,
                '90' => 90,
                default => 30
            };
            $query->recent($days);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->get('status') === 'successful') {
                $query->successful();
            } elseif ($request->get('status') === 'failed') {
                $query->failed();
            }
        }
        
        $activities = $query->paginate(6);
        
        // Get statistics
        $stats = [
            'total_logins' => $user->loginActivities()->count(),
            'successful_logins' => $user->loginActivities()->successful()->count(),
            'failed_logins' => $user->loginActivities()->failed()->count(),
            'last_login' => $user->loginActivities()->successful()->latest('login_at')->first(),
            'unique_ips' => $user->loginActivities()->distinct('ip_address')->count('ip_address'),
        ];
        
        return view('web.user-portal.login-activities.index', compact('activities', 'stats'));
    }
    
    /**
     * Show details of a specific login activity.
     */
    public function show(Request $request, UserLoginActivity $loginActivity): View
    {
        // Ensure user can only view their own activities
        if ($loginActivity->user_id !== $request->user()->id) {
            abort(403);
        }
        
        return view('web.user-portal.login-activities.show', compact('loginActivity'));
    }
}
