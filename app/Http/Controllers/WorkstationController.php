<?php

namespace App\Http\Controllers;

use App\Models\DeviceWorkstation;
use App\Models\Workstations;
use Illuminate\Http\Request;

class WorkstationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $deviceWorkstations = DeviceWorkstation::with(['workstation', 'device'])->get();

    foreach ($deviceWorkstations as $dw) {
    echo $dw->workstation->pc_code;  //workstation name
    echo $dw->workstation->is_active; //workstation status
    echo $dw->device->device_uid; //device UID
    echo $dw->device->is_active; //device status
}
        return view('admin.workstation.index', compact('deviceWorkstations'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.workstation.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
