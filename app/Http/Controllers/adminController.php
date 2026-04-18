<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function analytics(){
        return view('admin.analytics.index');
    }
    public function workstation(){
        return view('admin.workstation.index');
    }
    public function workstation_view(){
        return view('admin.workstation.show');
    }
}

