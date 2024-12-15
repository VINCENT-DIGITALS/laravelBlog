<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Add this import

class FacebookController extends Controller
{
    // Redirect to Facebook
    public function redirectToFacebook(Request $request)
    {
        // Capture state from the request (e.g., return URL or other data)
        $state = $request->get('state');

        // Store the state in the session
        $request->session()->put('state', $state);
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook Callback
    public function handleFacebookCallback()
    {
        try {

            // Fetch the user from Facebook
            $facebookUser = Socialite::driver('facebook')->user();

            // Check if user data is retrieved correctly
            // dd($facebookUser); // Check if user data is returned properly

            // Access the ID, Name, and Email
            $facebookId = $facebookUser->getId();
            $facebookName = $facebookUser->getName();
            $facebookEmail = $facebookUser->getEmail();
            // dd($facebookId, $facebookName, $facebookEmail);
            // Check if the user already exists by email
            $user = User::where('email', $facebookEmail)->first();
            // Dump the user data to check if it's being fetched properly
            // dd($user);
            if (!$user) {
                // Create a new user if not exists
                User::create([
                    'username' => $facebookName,
                    'email' => $facebookEmail,
                    'provider_id' => $facebookId
                ]);

                DB::commit();
            }
            $user = User::where('email', $facebookEmail)->first();
            // Store user details in session
            Session::put('user_id', $user->id);
            Session::put('username', $facebookName);
            Session::put('email', $facebookEmail);
            Session::put('role', 'Facebook User'); // Role can be customized as needed

            // Retrieve the state from the session
            $state = Session::get('state');
            // Check if a state (e.g., return URL) is provided
            if ($state) {
                // Redirect to the state URL if it exists
                return redirect($state)->with(['msg' => ['success', 'Logged in successfully!']]);
            }
            // Success message
            $msg = ['success', 'Student Data is Added, Please Log In!'];

            return redirect()->route('returnHome')->with(['msg' => $msg]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $msg = ['danger', $e->errorInfo[2]];
            } else {

                $msg = ['danger', 'Error in Adding Data! ' . $e->errorInfo[2]];
            }

            return redirect()->route('userLogInForm')->with(['msg' => $msg]);;
        }
    }
}
