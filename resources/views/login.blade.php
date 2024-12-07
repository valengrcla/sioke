<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOKE - Okene Coffee Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lusitana';
            background-image: url('{{ asset('images/okenebckg.png') }}'); 
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            color: #e6a700;
            text-align: center;
            overflow: hidden; 
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; 
            margin-top: -60px; 
            gap: 10px; 
        }

        .content img {
            max-width: 300px; 
            height: auto; 
        }

        h1 {
            font-family: 'Lusitana';
            font-size: 3em; 
            font-weight: 600;
        }

        .login-button {
            margin-top: 5px; 
            padding: 12px 25px;
            font-size: 1em;
            color: #333;
            background-color: #FFC107;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #e6a700;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7); 
            color: #fff; 
            text-align: center;
            padding: 10px 0;
            font-size: 1em;
            width: 100%; 
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="content">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo Okene Coffee">
        <h1>Sistem Pengelolaan Okene Coffee</h1>
        <a href="{{ route('login') }}" class="login-button">Log in</a>
    </div>
    <footer>
        &copy; 2024 Okene Coffee. All rights reserved.
    </footer>
</body>
</html>
