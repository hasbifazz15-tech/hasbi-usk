<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta - HASBI USK</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #111;
        }

        header {
            padding: 18px 7%;
            background: white;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        main {
            width: 86%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .menu-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 24px;
        }

        .menu-card p {
            color: #666;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            border: 1px solid #111;
            border-radius: 5px;
            background: #111;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-outline {
            background: white;
            color: #111;
        }

        @media (max-width: 650px) {
            .menu { grid-template-columns: 1fr; }
            main { width: 92%; }
            header { padding: 16px 4%; }
        }
    </style>
</head>
<body>

<header>
    <strong>HASBI USK</strong>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline">Logout</button>
    </form>
</header>

<main>
    <h1>Dashboard Peserta</h1>

    <p>Selamat datang, {{ Auth::user()->name }}.</p>
    <p>Kelola profil dan pendaftaran sertifikasi kamu di sini.</p>

    <h2>Menu Peserta</h2>

    <section class="menu">
        <div class="menu-card">
            <h3>Profil Saya</h3>
            <p>Ubah data diri, upload dokumen, ganti password, dan cek status verifikasi.</p>
            <a href="{{ route('user.profil') }}" class="btn">Buka Profil</a>
        </div>

        <div class="menu-card">
            <h3>Skema Sertifikasi</h3>
            <p>Lihat skema yang tersedia dan daftar sertifikasi.</p>
            <a href="{{ route('user.skema.index') }}" class="btn">Lihat Skema</a>
        </div>

        <div class="menu-card">
            <h3>Pendaftaran Saya</h3>
            <p>Lihat riwayat dan status pendaftaran sertifikasi.</p>
            <a href="{{ route('user.pendaftaran') }}" class="btn">Lihat Riwayat</a>
        </div>
    </section>
</main>

</body>
</html>