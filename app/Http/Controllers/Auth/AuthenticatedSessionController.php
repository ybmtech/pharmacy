<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user_role=auth()->user()->roles->pluck('name')[0];


        if($user_role=="admin"){
            return redirect()->intended('/admin/dashboard');
        }

        elseif($user_role=="pharmacist"){
            return redirect()->intended('/pharmacy/dashboard');
        }
        elseif($user_role=="doctor"){
            return redirect()->intended('/doctor/dashboard');
        }
        elseif($user_role=="driver"){
            return redirect()->intended('/driver/dashboard');
        }
        elseif($user_role=="student" || $user_role=="non student"){
            return redirect()->intended('/patient/dashboard');
        }
      
        else{
            return redirect()->route('login');
        }
     
        
       
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
