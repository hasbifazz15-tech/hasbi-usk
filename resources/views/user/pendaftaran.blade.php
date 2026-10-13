
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Saya</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #111827;
        }

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
        }

        .muted {
            color: #6b7280;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            background: #111827;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f9fafb;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            background: #f3f4f6;
            color: #374151;
            border-radius: 20px;
            font-size: 12px;
        }

        .success {
            padding: 12px 15px;
            border-radius: 7px;
            background: #dcfce7;
            color: #166534;
            margin-bottom: 20px;
        }

        .error {
            padding: 12px 15px;
            border-radius: 7px;
            background: #fee2e2;
            color: #991b1b;
            margin-bottom: 20px;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 600px) {
            .container {
                margin: 25px auto;
            }

            .card {
                padding: 12px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ route('user.dashboard') }}" class="back">
        &larr; Kembali ke Dashboard
    </a>

    <div class="header">
        <div>
            <h1>Pendaftaran Saya</h1>
            <p class="muted">
                Riwayat pendaftaran sertifikasi kamu.
            </p>
        </div>

        <a href="{{ route('user.skema.index') }}" class="btn">
            + Daftar Skema
        </a>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <h3>Riwayat Sertifikasi</h3>

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

                        <td>{{ $item->skema->kode ?? '-' }}</td>
                        <td>{{ $item->skema->nama ?? '-' }}</td>

                        <td>
                            <span class="status">
                                {{ $item->status ?? '-' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada pendaftaran sertifikasi.
                            <br><br>
<a href="{{ route('user.skema.index') }}" class="btn">
    Pilih Skema
</a>                                Pilih Skema
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
