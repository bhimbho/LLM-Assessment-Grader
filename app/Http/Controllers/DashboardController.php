<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $assessmentCounts = Assessment::whereRelation('assignment', 'user_id', auth()->user()->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $pendingCount = $assessmentCounts['pending'] ?? 0;
        $completedCount = $assessmentCounts['completed'] ?? 0;

        if (auth()->user()->role == 'admin') {
            $users = User::count();
        }
            
        return view('dashboard.index', compact('pendingCount', 'completedCount', 'users'));
    }
}
