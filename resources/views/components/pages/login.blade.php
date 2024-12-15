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
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Spacing between buttons */
        }

        .social-login a {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            /* Space for the icon */
            padding: 12px 15px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            color: white;
            /* Ensure text is visible on colored backgrounds */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        /* Facebook Button */
        .facebook-login-button {
            background-color: #4267B2;
        }

        .facebook-login-button:hover {
            background-color: #365899;
            transform: translateY(-2px);
        }

        /* Google Button */
        .google-login-button {
            background-color: #DB4437;
        }

        .google-login-button:hover {
            background-color: #C23321;
            transform: translateY(-2px);
        }

        /* Adding Icons */
        .social-login a i {
            font-size: 1.2rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 600px) {
            .social-login a {
                font-size: 0.9rem;
                padding: 10px;
            }
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
            <a href="{{ route('Home') }}">Guest |</a>
            <a href="{{ route('registerForm') }}">Sign up</a>
        </form>

        <div class="social-login">
            <a href="{{ route('facebook.login', ['state' => url('/Home')]) }}" class="facebook-login-button">
                <i class="fab fa-facebook-f"></i> Login with Facebook
            </a>
            <a href="{{ route('auth.google', ['state' => url('/Home')]) }}" class="google-login-button">
                <i class="fab fa-google"></i> Login with Google
            </a>
        </div>


    </div>

    @include('includes.js')
</body>

</html>
