<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $assessmentCounts = Assessment::whereRelation('question', 'user_id', auth()->user()->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $pendingCount = $assessmentCounts['pending'] ?? 0;
        $completedCount = $assessmentCounts['completed'] ?? 0;
        $users = null;
        if (auth()->user()->role == 'admin') {
            $users = User::count();
        }
        
        return view('dashboard.index', compact('pendingCount', 'completedCount', 'users'));
    }
}
