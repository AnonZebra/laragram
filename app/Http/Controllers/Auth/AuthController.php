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

        $user = User::where('email', $credentials['email'])
            ->first();
        
        if ($user && ($user->locked_flag == 1)) {
            return back()->withErrors([
                'login_error' => __("The account is locked. Please try again in one minute."),
            ]);
        }
        

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user->error_count = 0;
            $user->save();

            return redirect(route('user.home'))
                ->with(['login_success' => __("You are now logged in")]);
        }

        if ($user) {
            $user->error_count += 1;
            if ($user->error_count > 5) {
                $user->locked_flag = 1;
            }
            $user->save();
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
