<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
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
        $user = User::updateOrCreate([
            'email' => $request->input('email')
        ],[
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'app_logged_in_at' => Carbon::now(),
            'app_registered_at' => Carbon::now()
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

            $user = Auth::user();
            $user->app_logged_in_at = Carbon::now();
            $user->save();

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
