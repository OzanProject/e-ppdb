<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbTrack;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalRegistrations = PpdbRegistration::count();
        
        $totalCapacity = PpdbTrack::sum('quota');
        $availableQuota = $totalCapacity - $totalRegistrations;
        
        $totalVerified = PpdbRegistration::where('status', 'verified')->count();
        
        $totalAccepted = PpdbRegistration::where('status', 'accepted')->count();

        // Recent Registrations (Latest 5)
        $recentRegistrations = PpdbRegistration::with('user', 'track')
            ->latest()
            ->take(5)
            ->get();

        // Registration by Track
        $registrationsByTrack = PpdbTrack::withCount('registrations')->get();

        // Chart Data: Registrations per Day (Last 7 Days)
        $dailyRegistrations = PpdbRegistration::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $chartLabels = $dailyRegistrations->keys()->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $chartData = $dailyRegistrations->values();

        return view('backend.dashboard', compact(
            'totalRegistrations', 
            'availableQuota', 
            'totalVerified', 
            'totalAccepted',
            'recentRegistrations',
            'registrationsByTrack',
            'chartLabels',
            'chartData'
        ));
    }
}
