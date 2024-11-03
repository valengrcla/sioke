<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIOKE</title>
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            background-image: url('images/okenebckg.png'); /* Update this with the correct path */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        /* Overlay effect */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2); /* Darker overlay */
            z-index: 0;
        }
        /* Container styling */
        .login-container {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
            text-align: center;
        }
        /* Kontainer untuk logo dan judul */
        .logo-title-container {
            display: flex;
            align-items: center; /* Vertically center the logo and text */
            justify-content: space-between; /* Distribute space between logo and text */
            background-color: #FFC107; /* Yellow background */
            padding: 15px; /* Add some padding */
            border-radius: 5px; /* Slightly rounded corners */
            margin-bottom: 25px; /* Space below the container */
        }
        /* Header styling */
        .login-container h2 {
            font-size: 24px;
            margin-bottom: 0; /* Remove bottom margin */
            color: #333; /* Change text color to dark */
            text-align: left; /* Align text to the left */
        }
        .logo-container img {
            width: 60px; /* Smaller, circular logo */
            height: 60px;
            border-radius: 50%; /* Makes the image round */
        }
        /* Input fields */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            font-weight: 600;
            display: block;
            font-size: 14px;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }
        /* Button styling */
        .login-button {
            background-color: #FFC107;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 20px;
        }
        .login-button:hover {
            background-color: #e6a700;
        }
        /* Change password link */
        .change-password {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            text-align: left;
        }
        .change-password:hover {
            text-decoration: underline;
        }
        .alert {
            color: red; /* Mengubah warna teks menjadi merah */
        }

    </style>
</head>
<body>
    <div class="overlay"></div> <!-- Overlay effect -->

    <div class="login-container">
        <!-- Logo and title -->
        <div class="logo-title-container">
            <h2>Selamat datang,<br> di SIOKE</h2>
            <div class="logo-container">
                <img src="images/logo.png" alt="Okene Logo"> <!-- Update path if necessary -->
            </div>
        </div>
        @if(Session::has('error'))
        <div class="alert alert-danger" role="alert" style="text-align: center">
            {{Session::get('error')}}
        </div>
        @endif

        <!-- Login form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Password">
            </div>
            <a href="#" class="change-password">Change Password</a>
            <button type="submit" class="login-button">Log in</button>
        </form>
    </div>
</body>
</html>
