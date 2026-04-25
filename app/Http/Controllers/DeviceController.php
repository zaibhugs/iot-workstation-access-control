<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(){
        return view ('admin.device.index');
    }
    public function create(){
        return view('admin.device.add');
    }
}
