<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginFormRequest;

use App\Models\User;

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
        $user = User::getUserByEmail($credentials['email']);

        if ($user && $user->isLockedOut()) {
            return back()->withErrors([
                'login_error' => __("The account is locked. Please try again in one minute."),
            ]);
        }
        

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user->resetErrorCount();

            return redirect(route('user.home'))
                ->with(['login_success' => __("You are now logged in")]);
        }

        $errArr = [
            'login_error' => __("The provided credentials do not match our records.")
        ];

        if ($user) {
            $lockedOut = $user->incrementErrorCount();
            if ($lockedOut) {
                $errArr = [
                    'login_error' => __("toomanyloginattempts")
                ];
            }
        }

        return back()->withErrors($errArr);
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
