<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    $credentials = $request->validate([
        'name' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()
        ->withErrors(['name' => 'Wrong username or password.'])
        ->withInput();
    }
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255|unique:users,name',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|min:6',
        ]);

        $user=User::create([
        'name'=>$validated['name'],
        'email'=>$validated['email'],
        'password'=>Hash::make($validated['password']),
    ]);
        Auth::login($user);
    return redirect()->route('dashboard');
    
    }
    public function logout(Request $request){
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
    }
}
