<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitorSignin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get lead trends data for last 7 days
        $leadTrends = collect(range(6, 0))->map(function($i) use ($user) {
            $date = now()->subDays($i);
            return [
                'date' => $date->format('M j'),
                'count' => VisitorSignin::whereHas('property', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->whereDate('created_at', $date)->count()
            ];
        });

        // Get lead pipeline data
        $leadPipeline = [
            'new' => VisitorSignin::whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('lead_status', 'new')->count(),
            'contacted' => VisitorSignin::whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('lead_status', 'contacted')->count(),
            'qualified' => VisitorSignin::whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('lead_status', 'qualified')->count(),
            'closed' => VisitorSignin::whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('lead_status', 'closed')->count(),
        ];

        return view('dashboard', compact('leadTrends', 'leadPipeline'));
    }
}
