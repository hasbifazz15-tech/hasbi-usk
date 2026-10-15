<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
        .menu-card p { color: #666; line-height: 1.6; }
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
        .btn-outline { background: white; color: #111; }
        @media (max-width: 650px) {
            .menu { grid-template-columns: 1fr; }
            main { width: 92%; }
            header { padding: 16px 4%; }
        }
    </style>
</head>
<body>
<header>
    <strong>HASBI USK — ADMIN</strong>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline" type="submit">Logout</button>
    </form>
</header>

<main>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }}.</p>
    <p>Kelola data peserta dan sertifikasi melalui menu berikut.</p>

    <section class="menu">
        <div class="menu-card">
            <h3>Data Peserta</h3>
            <p>Total peserta: {{ $totalPeserta }}</p>
            <a href="{{ route('peserta.index') }}" class="btn">Kelola Peserta</a>
        </div>

        <div class="menu-card">
            <h3>Skema Sertifikasi</h3>
            <p>Total skema: {{ $totalSkema }}</p>
            <a href="{{ route('skema.index') }}" class="btn">Kelola Skema</a>
        </div>

        <div class="menu-card">
            <h3>Validasi Dokumen</h3>
            <p>Periksa dokumen yang diunggah peserta.</p>
            <a href="{{ route('admin.validasi.index') }}" class="btn">Periksa Dokumen</a>
        </div>

        <div class="menu-card">
            <h3>Ringkasan Sertifikasi</h3>
            <p>Peserta lulus: {{ $pesertaLulus }}</p>
            <p>Peserta dalam proses/terdaftar: {{ $pesertaProses }}</p>
        </div>
    </section>
</main>
</body>
</html>