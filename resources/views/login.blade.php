<link href="https://fonts.googleapis.com/css2?family=Lusitana:wght@400;600&display=swap" rel="stylesheet">


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
            font-family: 'Lusitana', sans-serif;
            background-image:  url('{{ asset('images/okenebckg.png') }}'); /* Path ke gambar di public */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            text-align: center;
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
        }

        h1 {
            font-family: 'Lusitana', serif;
            font-size: 7em;
            font-weight: 600;
            margin-bottom: 30px;
        }

        p {
            font-family: 'Lusitana', serif;
            font-size: 3.5em;
            font-weight: 400;
            margin-bottom: 40px;
        }

        .login-button {
            display: inline-block;
            margin-top: 20px;
            padding: 15px 30px;
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
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="content">
        <h1>SIOKE</h1>
        <p>Sistem Pengelolaan Okene Coffee</p>
        
        <a href="{{ route('login') }}" class="login-button">Log in</a>
    </div>
</body>
</html>
