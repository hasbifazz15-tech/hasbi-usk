<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - HASBI USK</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            color: black;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        nav {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .content {
            margin: 120px 20px;
        }

        h1 {
            font-size: 40px;
        }

        p {
            color: #666;
        }

        a {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            text-decoration: none;
            border: 1px solid black;
            border-radius: 5px;
        }

        .login {
            color: black;
        }

        .register {
            background: black;
            color: white;
        }

        footer {
            padding: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">HASBI USK</div>
        <div>
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ route('register') }}" class="register">Register</a>
        </div>
    </nav>

    <div class="content">
        <h1>Selamat Datang</h1>
        <p>Sistem Pengelolaan Data Peserta Sertifikasi</p>

        <a href="{{ route('login') }}" class="register">Mulai Sekarang</a>
    </div>


</body>
</html>