<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - SIOKE</title>
    <link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Lusitana', sans-serif;
            background-image: url('images/okenebckg.png'); 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2); 
            z-index: 0;
        }
        .login-container {
            position: relative;
            background: #FFF7E5;
            padding: 30px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
            text-align: center;
        }
        .logo-title-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #FFC107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }
        .login-container h2 {
            font-size: 24px;
            margin-bottom: 0;
            color: #333;
            text-align: left;
        }
        .logo-container img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
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
        .alert {
            color: red;
            text-align: center;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #333;
        }
        .input-icon .form-control {
            padding-left: 35px; 
        }

    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="login-container">
        <div class="logo-title-container">
            <h2>Change Password</h2>
            <div class="logo-container">
                <img src="images/logo.png" alt="Okene Logo"> 
            </div>
        </div>
        
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('change.password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" class="form-control" required placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <div class="input-icon">
                    <i class="fas fa-key"></i>
                    <input type="password" id="new_password" name="new_password" class="form-control" required placeholder="New Password">
                </div>
            </div>
            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required placeholder="Confirm New Password">
                </div>
            </div>
            <button type="submit" class="login-button">Change Password</button>
        </form>
    </div>
</body>
</html>
