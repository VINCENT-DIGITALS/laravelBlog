<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Options</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
@include('includes.navbar')

<body>



    <div class="containerChooseLogin">
        <div class="login-options">
            <a href="{{ route('userLogInForm') }}" class="btn">User Login</a>
            <a href="{{ route('returnHome') }}" class="btn secondary">Continue as Guest</a>
            <a href="{{ route('adminLogInForm') }}" class="btn admin">Admin Login</a>
        </div>
    </div>



</body>
@include('includes.footer')

</html>
