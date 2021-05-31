<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginFormRequest;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function showLogin(): View
    {
        return view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest $request
     */
    public function processLogin(LoginFormRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => __("The provided credentials do not match our records."),
        ]);
    }
}
