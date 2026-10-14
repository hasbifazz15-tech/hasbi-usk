
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #111;
        }

        header {
            padding: 18px 7%;
            background: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        header strong {
            font-size: 20px;
        }

        main {
            width: 86%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }

        .stat p {
            color: #666;
            font-size: 14px;
            margin-top: 0;
        }

        .stat h2 {
            margin-bottom: 0;
            font-size: 28px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .menu-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 24px;
        }

        .menu-card h3 {
            margin-top: 0;
        }

        .menu-card p {
            min-height: 42px;
            color: #666;
            font-size: 14px;
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
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background: #333;
        }

        .btn-outline {
            background: white;
            color: #111;
        }

        .btn-outline:hover {
            background: #eee;
        }

        .logout-form {
            margin: 0;
        }

        @media (max-width: 800px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu {
                grid-template-columns: 1fr;
            }

            main {
                width: 92%;
            }
        }

        @media (max-width: 450px) {
            header {
                padding: 16px 4%;
            }

            header strong {
                font-size: 17px;
            }

            .stats {
                gap: 10px;
            }

            .stat {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<header>
    <strong>HASBI USK</strong>

    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="btn btn-outline">Logout</button>
    </form>
</header>

<main>
    <section class="welcome">
        <h1>Dashboard Peserta</h1>
        <p>Selamat datang, {{ Auth::user()->name }}.</p>
    </section>

    <section class="stats">
        <div class="stat">
            <p>Total Pendaftaran</p>
            <h2>{{ $totalPendaftaran }}</h2>
        </div>

        <div class="stat">
            <p>Dalam Proses</p>
            <h2>{{ $totalProses }}</h2>
        </div>

        <div class="stat">
            <p>Lulus Sertifikasi</p>
            <h2>{{ $totalLulus }}</h2>
        </div>

        <div class="stat">
            <p>Skema Tersedia</p>
            <h2>{{ $totalSkema }}</h2>
        </div>
    </section>

    <h2>Menu Peserta</h2>

    <section class="menu">
        <div class="menu-card">
            <h3>Profil Saya</h3>
            <p>Ubah nama, email, NIK, nomor HP, dan password akun kamu.</p>
            <a href="{{ route('user.profil') }}" class="btn">Edit Profil</a>
        </div>

        <div class="menu-card">
            <h3>Skema Sertifikasi</h3>
            <p>Lihat skema yang tersedia dan lakukan pendaftaran sertifikasi.</p>
            <a href="{{ route('user.skema.index') }}" class="btn">Lihat Skema</a>
        </div>

        <div class="menu-card">
            <h3>Pendaftaran Saya</h3>
            <p>Lihat riwayat pendaftaran dan status sertifikasi kamu.</p>
            <a href="{{ route('user.pendaftaran') }}" class="btn">Lihat Riwayat</a>
        </div>
    </section>
</main>

</body>
</html>