<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class GoogleController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle(Request $request)
    {
        try {
            // Capture state from the request (e.g., return URL or other data)
            $state = $request->get('state');

            // Store the state in the session
            $request->session()->put('state', $state);
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {

            $msg = ['danger', 'Error in Adding Data! ' . $e];


            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        }
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            // Get the Google user details
            $googleUser = Socialite::driver('google')->user();

            // For testing: debug the Google user object
            // dd($googleUser);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {

            $msg = ['danger', 'Error in Adding Data! ' . $e];


            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        } catch (\Exception $e) {


            $msg = ['danger', 'Error in Adding Data! ' . $e];


            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        }

        try {
            // Access the ID, Name, and Email
            $googleId = $googleUser->getId();
            $googleName = $googleUser->getName();
            $googleEmail = $googleUser->getEmail();

            // Check if the user already exists in the database
            $user = User::where('email', $googleEmail)->first();

            if (!$user) {
                DB::beginTransaction();
                try {
                    // Create a new user if not exists
                    User::create([
                        'username' => $googleName,
                        'email' => $googleEmail,
                        'provider_id' => $googleId,
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();

                    $msg = ['danger', 'Error in Adding Data! ' . $e];


                    return redirect()->route('userLogInForm')->with(['msg' => $msg]);
                }
            }

            // Store user details in session
            try {
                Session::put('user_id', $user->id);
                Session::put('username', $googleName);
                Session::put('email', $googleEmail);
                Session::put('role', 'Google User'); // Role can be customized as needed
            } catch (\Exception $e) {

                $msg = ['danger', 'Error in Adding Data! ' . $e];


                return redirect()->route('userLogInForm')->with(['msg' => $msg]);
            }

            // Success message
            $msg = ['success', 'Student Data is Added, Please Log In!'];
            return redirect()->route('returnHome')->with(['msg' => $msg]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $msg = ['danger', 'Duplicate entry: ' . $e->errorInfo[2]];
            } else {
                $msg = ['danger', 'Database error: ' . $e->errorInfo[2]];
            }
            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        } catch (\Exception $e) {

            $msg = ['danger', 'Error in Adding Data! ' . $e];


            return redirect()->route('userLogInForm')->with(['msg' => $msg]);
        }
    }
}
