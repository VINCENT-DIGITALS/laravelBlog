<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add this line -->
    <style>
        /* Reset basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #4CAF50, #2F8F50);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 15px;
            padding: 20px 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        form {
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        button:active {
            background-color: #3e8e41;
            transform: translateY(0);
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login button {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .facebook-login-button {
            background-color: #4267B2;
            color: white;
            border: none;
        }

        .facebook-login-button:hover {
            background-color: #365899;
        }

        .google-login-button {
            background-color: #DB4437;
            color: white;
            border: none;
        }

        .google-login-button:hover {
            background-color: #C23321;
        }

        #responseMessage {
            margin-top: 20px;
            font-size: 16px;
            color: #4CAF50;
        }

        .hidden {
            display: none;
        }


        /* Container for the toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Toast style */
        .toast {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 250px;
            max-width: 300px;
            animation: slideIn 0.5s ease-out, fadeOut 3s 2.5s forwards;
        }

        /* Success toast (green) */
        .toast.alert-success {
            background-color: #28a745;
        }

        /* Danger toast (red) */
        .toast.alert-danger {
            background-color: #dc3545;
        }

        /* Animation for sliding in */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Fade out animation */
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        /* Container for the toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Toast style */
        .toast {
            background-color: #dc3545;
            /* Red background for errors */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 250px;
            max-width: 300px;
            animation: slideIn 0.5s ease-out, fadeOut 3s 2.5s forwards;
        }

        /* Animation for sliding in */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Fade out animation */
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>



    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

</head>

<body>
    <div class="container">
        <!-- Display Validation Errors -->
        {{-- @if ($errors->any())
            <div class="toast-container">
                <div class="toast alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif --}}

        @if (session('msg'))
            <div class="toast-container">
                <div class="toast alert-{{ session('msg')[0] }}">
                    <p>{{ session('msg')[1] }}</p>
                </div>
            </div>
        @endif


        <h2>User Login</h2>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf <!-- CSRF Token -->
            <input type="text" id="email" name="email" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <div id="responseMessage" style="display: none;"></div>

            <!-- <div id="status"></div> -->
            <button type="submit" name="find_user">Login</button><br>
            <a href="{{ route('Home') }}">Gusest |</a>
            <a href="{{ route('registerForm') }}">Sign up</a>
        </form>

        <div class="social-login">
            <!-- Custom Facebook Login Button -->
            <a href="{{ route('facebook.login') }}" class="btn btn-primary">
                Login with Facebook
            </a>
            <a href="{{ route('auth.google') }}" class="btn btn-primary">
                Login with Google
            </a>



            <!-- Sign In With Google button with HTML data attributes API -->
            {{-- <div id="g_id_onload"
                data-client_id="624367051637-26ok23b3casi34oeo728ee1jltjb04bo.apps.googleusercontent.com"
                data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>

            <div class="g_id_signin" data-type="standard">
            </div> --}}

            <!-- User Profile Display -->

            <div class="pro-data hidden"></div>
        </div>
    </div>

    @include('includes.js')
</body>

</html>
