<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        Auth::login($user);
        $request->session()->regenerate();


        return redirect(route('profile'));
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated(), true)) {
            $request->session()->regenerate();

            return redirect('profile');
        }

        return back()->with([
            'email' => 'invalid'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login.form'));
    }

    public function profile()
    {
        return view('user.profile', ['user' => UserResource::make(Auth::user())]);
    }
}
