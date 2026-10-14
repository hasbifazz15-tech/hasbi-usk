<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #111;
        }

        header {
            padding: 20px 7%;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 21px;
            font-weight: bold;
        }

        button, .btn {
            padding: 10px 16px;
            border: 1px solid #111;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button {
            background: white;
            color: #111;
        }

        main {
            width: 86%;
            max-width: 1000px;
            margin: 40px auto;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        .stats, .menus {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .card {
            padding: 24px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .card h2, .card h3 {
            margin-top: 0;
        }

        .number {
            font-size: 28px;
            font-weight: bold;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background: #111;
            color: white;
            text-decoration: none;
            margin-top: 8px;
        }

        @media (max-width: 600px) {
            main {
                width: 90%;
            }

            .stats, .menus {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">HASBI USK | ADMIN</div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</header>

<main>
    <h1>Dashboard Admin</h1>

    <p class="subtitle">
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    <div class="stats">
        <div class="card">
            <p>Total Peserta</p>
            <div class="number">{{ $totalPeserta }}</div>
        </div>

        <div class="card">
            <p>Total Skema</p>
            <div class="number">{{ $totalSkema }}</div>
        </div>

        <div class="card">
            <p>Peserta Lulus</p>
            <div class="number">{{ $pesertaLulus }}</div>
        </div>

        <div class="card">
            <p>Peserta Dalam Proses</p>
            <div class="number">{{ $pesertaProses }}</div>
        </div>
    </div>

    <h2>Menu Admin</h2>

    <div class="menus">
        <div class="card">
            <h3>Data Peserta</h3>
            <p>Tambah, edit, lihat, dan hapus data peserta sertifikasi.</p>

            <a href="{{ route('peserta.index') }}" class="btn">
                Kelola Peserta
            </a>
        </div>

        <div class="card">
            <h3>Skema Sertifikasi</h3>
            <p>Kelola informasi skema sertifikasi yang tersedia.</p>

            <a href="{{ route('skema.index') }}" class="btn">
                Kelola Skema
            </a>
        </div>
    </div>
</main>

</body>
</html>