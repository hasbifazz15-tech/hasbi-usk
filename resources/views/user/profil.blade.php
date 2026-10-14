
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #111;
        }
        main {
            max-width: 600px;
            margin: 30px auto;
        }
        .card {
            background: white;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 15px 0 7px;
        }
        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button, .btn {
            display: inline-block;
            margin-top: 18px;
            padding: 11px 15px;
            border: none;
            border-radius: 5px;
            background: #111;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        .success { color: #166534; margin: 12px 0; }
        .error { color: #b91c1c; margin-top: 6px; font-size: 13px; }
    </style>
</head>
<body>
<main>
    <a class="btn" href="{{ route('user.dashboard') }}">Kembali ke Dashboard</a>
    <h1>Profil Saya</h1>

    <section class="card">
        <h2>Data Diri</h2>

        @if (session('profile_success'))
            <p class="success">{{ session('profile_success') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('user.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Nama lengkap</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" required>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>

            <label for="nik">NIK (16 digit)</label>
            <input
                id="nik"
                name="nik"
                type="text"
                inputmode="numeric"
                maxlength="16"
                pattern="[0-9]{16}"
                value="{{ old('nik', $peserta->nik ?? '') }}"
                placeholder="Masukkan 16 digit NIK"
                required
            >

            <label for="no_hp">Nomor HP</label>
            <input
                id="no_hp"
                name="no_hp"
                type="text"
                value="{{ old('no_hp', $peserta->no_hp ?? '') }}"
            >

            <button type="submit">Simpan Perubahan</button>
        </form>
    </section>

    <section class="card">
        <h2>Ganti Password</h2>

        @if (session('password_success'))
            <p class="success">{{ session('password_success') }}</p>
        @endif

        <form action="{{ route('user.profil.password') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="current_password">Password lama</label>
            <input id="current_password" name="current_password" type="password" required>

            <label for="password">Password baru</label>
            <input id="password" name="password" type="password" minlength="8" required>

            <label for="password_confirmation">Konfirmasi password baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>

            <button type="submit">Simpan Password</button>
        </form>
    </section>
</main>
</body>
</html>