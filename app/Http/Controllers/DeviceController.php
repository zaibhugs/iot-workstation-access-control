<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        // This creates a 'device_workstations_count' attribute on each model
        $query = Device::withCount('deviceWorkstations');

        //Handle Search (Device Code)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('device_uid', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
            });
        }

        //Handle Status Filter (Active/Inactive)
        if ($request->filled('status')) {
            $status = $request->input('status') === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        //Fetch the data with pagination

        $devices = $query->latest()->paginate(10)->withQueryString();

        // 5. Return the view with the data
        return view('admin.device.index', compact('devices'));
    }
    public function create(){
        return view('admin.device.add');
    }
    public function store(Request $request){
    $request->validate([
        'device_uid' => 'required|unique:devices,device_uid',
        'name' => 'required',
        'is_active' => 'required|boolean',
    ]);

    Device::create([
        'device_uid' => $request->input('device_uid'),
        'name' => $request->input('name'),
        'is_active' => $request->input('is_active'),
    ]);

    return redirect()->route('device')->with('success', 'Device added successfully.');
    }
    public function update(Request $request, Device $device){
        $request->validate([
            'name' => 'required',
            'is_active' => 'required|boolean',
        ]);

        $device->update([
            'name' => $request->input('name'),
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('device')->with('success', 'Device updated successfully.');
    }
}
