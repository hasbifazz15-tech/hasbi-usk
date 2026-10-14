
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sertifikasi</title>

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
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        h1 {
            margin: 0 0 8px;
            color: #222;
        }

        .description {
            color: #777;
            margin-bottom: 25px;
            line-height: 1.5;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #222;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #111827;
            color: white;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            background: #374151;
        }

        .error {
            color: #dc2626;
            background: #fee2e2;
            padding: 10px;
            border-radius: 7px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .bottom {
            margin-top: 22px;
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
            color: #777;
        }

        .bottom a {
            color: #222;
            font-weight: bold;
            text-decoration: none;
        }

        .bottom a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h1>Login</h1>

        <div class="description">
            Aplikasi Pengelolaan Data Peserta Sertifikasi
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                autocomplete="email"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Login</button>
        </form>

        <div class="bottom">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar di sini</a>

            <br>

            <a href="{{ route('welcome') }}">Kembali ke halaman utama</a>
        </div>
    </div>
</body>
</html>
