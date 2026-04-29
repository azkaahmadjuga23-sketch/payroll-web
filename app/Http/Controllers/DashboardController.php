<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::where('status', 'active')->count();

        $latestPayroll = Payroll::with('details.employee')
            ->orderByDesc('period')
            ->first();

        $latestPeriod = $latestPayroll
            ? \Carbon\Carbon::parse($latestPayroll->period . '-01')->format('F Y')
            : null;

        $totalPayroll = $latestPayroll
            ? $latestPayroll->details->sum('net_salary')
            : 0;

        $totalSlips = $latestPayroll
            ? $latestPayroll->details->count()
            : 0;

        $latestDetails = $latestPayroll
            ? $latestPayroll->details->take(5)
            : collect();

        return view('dashboard', compact(
            'totalEmployees',
            'latestPayroll',
            'latestPeriod',
            'totalPayroll',
            'totalSlips',
            'latestDetails'
        ));
    }
}
