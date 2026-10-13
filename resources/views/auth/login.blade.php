<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .login-box {
            width: 380px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        h1 {
            margin: 0 0 8px;
        }

        p {
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 7px;
            background: #111827;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h1>Login </h1>
    <p>Aplikasi Pengelolaan Data Peserta Sertifikasi</p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label>Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="admin@email.com"
            required
        >

        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="Masukkan password"
            required
        >

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>