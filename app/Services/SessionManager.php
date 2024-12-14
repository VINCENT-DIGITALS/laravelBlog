<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class SessionManager
{
    /**
     * Store visitor ID in the session if it doesn't exist.
     */
    public static function initializeVisitor()
    {
        if (!Session::has('visitor_id')) {
            Session::put('visitor_id', uniqid('visitor_', true));
        }
    }

    /**
     * Store user data in session after login.
     */
    public static function loginUserSession($userData, $role)
    {
        Session::put('user_id', $userData->id);
        Session::put('username', $userData->username);
        Session::put('email', $userData->email);
        Session::put('role', $role);
        Session::forget('visitor_id'); // Remove the visitor_id as the user has logged in
    }

    /**
     * Check if a user is logged in.
     */
    public static function isLoggedIn()
    {
        return Session::has('user_id');
    }

    /**
     * Check if the user is an admin.
     */
    public static function isAdmin()
    {
        return Session::get('role') === 'admin';
    }

    /**
     * Log out the user and clear all session data.
     */
    public static function logoutUser()
    {
        // Clear session variables
        Session::flush();

        // Redirect to homepage
        return redirect()->route('home'); // Assuming 'home' is your route name
    }

    /**
     * Restrict access to admin users.
     */
    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            return redirect()->route('login')->with('error', 'You do not have access to this page.');
        }
    }

    /**
     * Restrict access to logged-in users.
     */
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            return redirect()->route('login');
        }
    }
}
