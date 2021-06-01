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

            return redirect(route('user.home'))
                ->with(['login_success' => __("You are now logged in")]);
        }

        return back()->withErrors([
            'login_error' => __("The provided credentials do not match our records."),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('guest.showLogin'))
            ->with(['logout_success' => __("You are now logged out")]);;
    }
}
