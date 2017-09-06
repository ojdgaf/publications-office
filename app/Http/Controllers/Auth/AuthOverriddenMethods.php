<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

trait AuthOverriddenMethods
{
    /*
    |--------------------------------------------------------------------------
    | AuthOverriddenMethods Trait
    |--------------------------------------------------------------------------
    |
    | This trait is used to override the Laravel foundation auth functions
    | which are in charge of returning views
    |
    */

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('pages/auth/login');
    }

    /**
    * Show the application registration form.
    *
    * @return \Illuminate\Http\Response
    */
   public function showRegistrationForm()
   {
       return view('pages/auth/register');
   }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('pages/auth/passwords/reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('pages/auth/passwords/email');
    }
}
