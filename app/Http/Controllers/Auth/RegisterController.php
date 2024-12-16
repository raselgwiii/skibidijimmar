<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'username' => ['required', 'string', 'max:100', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin'
            ]);

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login to continue.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Registration failed. Please try again. ' . $e->getMessage()
            ])->withInput();
        }
    }
}
