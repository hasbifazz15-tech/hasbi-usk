
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
            background: #f5f6f8;
            color: #1f2937;
        }

        header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .brand {
            font-size: 19px;
            font-weight: bold;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            font-size: 14px;
            color: #4b5563;
        }

        .logout {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            padding: 9px 13px;
            cursor: pointer;
        }

        main {
            width: 92%;
            max-width: 1150px;
            margin: 35px auto;
        }

        .welcome {
            background: #202124;
            color: white;
            padding: 32px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin: 0 0 12px;
            font-size: 28px;
        }

        .welcome p {
            margin: 0;
            color: #d1d5db;
            line-height: 1.7;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 11px 16px;
            border-radius: 7px;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }

        .btn-white {
            background: white;
            color: #202124;
        }

        .btn-dark {
            background: #202124;
            color: white;
        }

        .section-title {
            margin: 30px 0 16px;
        }

        .section-title h2 {
            font-size: 21px;
            margin: 0 0 7px;
        }

        .section-title p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px;
        }

        .stat-label {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
            margin-top: 13px;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .quick-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 23px;
        }

        .quick-card h3 {
            margin: 0 0 10px;
        }

        .quick-card p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .table-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px;
            overflow-x: auto;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .table-header h2 {
            margin: 0;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #f3f4f6;
            color: #374151;
            font-size: 12px;
        }

        .status.lulus {
            background: #dcfce7;
            color: #166534;
        }

        .status.proses, .status.terdaftar {
            background: #fef3c7;
            color: #92400e;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px 15px;
        }

        footer {
            padding: 25px;
            margin-top: 35px;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        @media (max-width: 850px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 550px) {
            header {
                padding: 16px 4%;
            }

            .brand {
                font-size: 16px;
            }

            .user-name {
                display: none;
            }

            main {
                width: 94%;
                margin-top: 22px;
            }

            .welcome {
                padding: 23px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .stats {
                gap: 10px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-number {
                font-size: 25px;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }

            .table-card {
                padding: 14px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="brand">Portal Sertifikasi</div>

    <div class="user-area">
        <span class="user-name">
            {{ auth()->user()->name }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>
</header>

<main>

    <!-- Sambutan -->
    <section class="welcome">
        <div>
            <h1>Halo, {{ auth()->user()->name }}!</h1>
            <p>
                Selamat datang di dashboard peserta sertifikasi.
                Pantau pendaftaran dan status sertifikasi kamu di sini.
            </p>
        </div>

        <a href="{{ route('user.skema.index') }}" class="btn btn-white">
            + Daftar Sertifikasi
        </a>
    </section>

    <!-- Ringkasan -->
    <div class="section-title">
        <h2>Ringkasan Pendaftaran</h2>
        <p>Informasi pendaftaran sertifikasi milik kamu.</p>
    </div>

    <section class="stats">

        <div class="stat-card">
            <p class="stat-label">Total Pendaftaran</p>
            <div class="stat-number">{{ $totalPendaftaran }}</div>
        </div>

        <div class="stat-card">
            <p class="stat-label">Dalam Proses</p>
            <div class="stat-number">{{ $totalProses }}</div>
        </div>

        <div class="stat-card">
            <p class="stat-label">Lulus Sertifikasi</p>
            <div class="stat-number">{{ $totalLulus }}</div>
        </div>

        <div class="stat-card">
            <p class="stat-label">Skema Tersedia</p>
            <div class="stat-number">{{ $totalSkema }}</div>
        </div>

    </section>

    <!-- Menu utama -->
    <div class="section-title">
        <h2>Menu Peserta</h2>
        <p>Pilih menu untuk melanjutkan aktivitas kamu.</p>
    </div>

    <section class="quick-links">

        <div class="quick-card">
            <h3>Daftar Skema</h3>
            <p>
                Lihat kode, nama, dan lembaga skema sertifikasi
                yang tersedia untuk pendaftaran.
            </p>
            <a href="{{ route('user.skema.index') }}" class="btn btn-dark">
                Lihat Skema
            </a>
        </div>

        <div class="quick-card">
            <h3>Pendaftaran Saya</h3>
            <p>
                Periksa riwayat pendaftaran dan status sertifikasi
                yang sedang kamu ikuti.
            </p>
            <a href="{{ route('user.pendaftaran') }}" class="btn btn-dark">
                Lihat Riwayat
            </a>
        </div>

    </section>

    <!-- Riwayat terbaru -->
    <div class="section-title">
        <h2>Pendaftaran Terbaru</h2>
        <p>Lima pendaftaran terakhir dari akun kamu.</p>
    </div>

    <section class="table-card">

        <div class="table-header">
            <h2>Riwayat Sertifikasi</h2>

            <a href="{{ route('user.pendaftaran') }}" class="btn btn-dark">
                Lihat Semua
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Daftar</th>
                    <th>Kode Skema</th>
                    <th>Nama Skema</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pendaftaranSaya as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->tanggal_daftar
                                ? \Illuminate\Support\Carbon::parse($item->tanggal_daftar)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td>
                            {{ $item->skema->kode ?? '-' }}
                        </td>

                        <td>
                            {{ $item->skema->nama ?? '-' }}
                        </td>

                        <td>
                            <span class="status {{ strtolower($item->status ?? '') }}">
                                {{ $item->status ?? 'Belum ada status' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Kamu belum memiliki pendaftaran sertifikasi.

                            <br><br>

                            <a href="{{ route('user.skema.index') }}"
                               class="btn btn-dark">
                                Mulai Pendaftaran
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </section>

</main>

<footer>
    Aplikasi Pengelolaan Data Peserta Sertifikasi
</footer>

</body>
</html>
