
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Sertifikasi</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 32px;
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
        }

        .brand {
            display: inline-block;
            margin-bottom: 28px;
            color: #222;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }

        h2 {
            margin: 0 0 8px;
            font-size: 25px;
        }

        .subtitle {
            margin: 0 0 24px;
            color: #777;
            font-size: 14px;
            line-height: 1.6;
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-size: 13px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #222;
        }

        .error {
            margin-top: 6px;
            color: #c62828;
            font-size: 12px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 13px;
        }

        .btn {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #222;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #444;
        }

        .bottom {
            margin-top: 22px;
            text-align: center;
            color: #777;
            font-size: 13px;
            line-height: 2;
        }

        .bottom a {
            color: #222;
            font-weight: bold;
            text-decoration: none;
        }

        .bottom a:hover {
            text-decoration: underline;
        }

        @media (max-width: 450px) {
            .container {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('welcome') }}" class="brand">
        SERTIFIKASI.
    </a>

    <h2>Buat Akun</h2>
    <p class="subtitle">
        Daftar untuk mengakses portal sertifikasi.
    </p>

    @if ($errors->any())
        <div class="alert">
            Periksa kembali data yang kamu masukkan.
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <label for="name">Nama lengkap</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Nama lengkap"
            maxlength="255"
            autocomplete="name"
            required
        >
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="nama@email.com"
            maxlength="255"
            autocomplete="email"
            required
        >
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Minimal 8 karakter"
            minlength="8"
            autocomplete="new-password"
            required
        >
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Konfirmasi password</label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Ulangi password"
            minlength="8"
            autocomplete="new-password"
            required
        >

        <button type="submit" class="btn">
            Daftar
        </button>
    </form>

    <div class="bottom">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>

        <br>

        <a href="{{ route('welcome') }}">
            &larr; Kembali ke halaman utama
        </a>
    </div>

</div>

</body>
</html>