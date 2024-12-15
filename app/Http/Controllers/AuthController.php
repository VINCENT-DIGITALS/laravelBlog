<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function chooseLogin()
    {
        return view('components.pages.choose_login');
    }
    public function returnHome()
    {
        return view('welcome');
    }
    public function userLogInForm()
    {
        return view('components.pages.login');
    }

    public function adminLogInForm()
    {
        return view('components.pages.admin_login');
    }
    public function registerForm()
    {
        return view('components.pages.register');
    }

    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // Determine the role name based on role value
                $roleName = $user->role == 1 ? 'Admin' : 'User';

                // Store user details in session
                Session::put('user_id', $user->id);
                Session::put('username', $user->username);
                Session::put('email', $user->email);
                Session::put('role', $roleName); // Store role as 'Admin' or 'User'
                // Flash success message to the session
                session()->flash('msg', ['success', 'Login successful. Redirecting...']);

                return response()->json(['success' => true, 'message' => 'Login successful'], 200);
            } else {
                // Flash error message to the session
                session()->flash('msg', ['danger', 'Invalid email or password.']);
                // Return invalid credentials message without redirection
                return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('msg', ['danger', 'Error in processing the request! ' . $e->getMessage()]);

            // Check for specific SQL error (like duplicate entries)
            $errorMessage = ($e->errorInfo[1] == 1062)
                ? $e->errorInfo[2]
                : 'Error in processing the request! ' . $e->errorInfo[2];

            // Return the error message directly as JSON (for AJAX) or display it in the same view
            return response()->json(['success' => false, 'message' => $errorMessage], 500);
        }
    }

    public function adminlogin(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = Admin::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                // Store user details in session
                Session::put('user_id', $user->id);
                Session::put('username', $user->username);
                Session::put('email', $user->email);
                Session::put('role', 'Admin'); // Store role as 'Admin' or 'User'
                
                // Flash success message to the session
                session()->flash('msg', ['success', 'Admin login successful. Redirecting...']);

                return response()->json(['success' => true, 'message' => 'Login successful'], 200);
            } else {
                // Flash error message to the session
                session()->flash('msg', ['danger', 'Invalid email or password.']);

                // Return invalid credentials message without redirection
                return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('msg', ['danger', 'Error in processing the request! ' . $e->getMessage()]);

            // Check for specific SQL error (like duplicate entries)
            $errorMessage = ($e->errorInfo[1] == 1062)
                ? $e->errorInfo[2]
                : 'Error in processing the request! ' . $e->errorInfo[2];

            // Return the error message directly as JSON (for AJAX) or display it in the same view
            return response()->json(['success' => false, 'message' => $errorMessage], 500);
        }
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:Cpassword',
        ]);

        try {
            User::create([
                'username' => $request->Username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 0,
                'provider' => 'Email/Password',
            ]);
            DB::commit();
            // Success message
            $msg = ['success', 'Student Data is Added, Please Log In!'];

            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                $msg = ['danger', $e->errorInfo[2]];
            } else {

                $msg = ['danger', 'Error in Adding Data! ' . $e->errorInfo[2]];
            }

            return redirect()->back()->with(['msg' => $msg]);
        }
    }



    // Logout user
    public function logout()
    {
        // Clear session and logout
        Session::flush();
        return redirect()->route('returnHome');
    }

    // Show registration form (if needed)
    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
