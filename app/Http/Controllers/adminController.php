<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceWorkstation;
use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Device stats
        $totalDevices = Device::count();
        $activeDevices = Device::where('is_active', 1)->count();
        $onlineDevices = Device::where('last_seen_at', '>=', now()->subMinutes(5))->count();

        // Workstation stats
        $totalWorkstations = Workstations::count();
        $activeWorkstations = Workstations::where('is_active', 1)->count();

        // Each device provides two slots; each device-workstation mapping occupies one.
        $totalSlots = $totalDevices * 2;
        $occupiedSlots = DeviceWorkstation::count();
        $slotUtilization = $totalSlots > 0 ? round(($occupiedSlots / $totalSlots) * 100) : 0;

        $weekStart = Carbon::today()->startOfWeek(Carbon::MONDAY);

        // Weekly Visitors (unique student sessions from Monday through Sunday)
        $weeklyVisitors = PcAccessLogs::where('occurred_at', '>=', $weekStart)
            ->distinct('student_external_id')->count('student_external_id');


        $male = [];
        $female = [];
        $columnChartDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $columnChartDays[] = $date->format('l');

            $male[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%1')
                ->distinct('student_external_id')
                ->count('student_external_id');

            $female[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%2')
                ->distinct('student_external_id')
                ->count('student_external_id');
        }


        $courseDistribution = PcAccessLogs::selectRaw('course, COUNT(*) as count')
            ->groupBy('course')
            ->pluck('count', 'course')
            ->toArray();

        $totalStudents = PcAccessLogs::distinct('student_external_id')->count('student_external_id');

        return view('admin.dashboard', compact(
            'totalDevices', 'activeDevices', 'onlineDevices',
            'totalWorkstations', 'activeWorkstations', 'slotUtilization',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'courseDistribution', 'totalStudents'
        ));
    }
}
