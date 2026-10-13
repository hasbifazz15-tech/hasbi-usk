
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skema Sertifikasi</title>

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
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
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

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
        }

        .btn-primary {
            background: #111827;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f9fafb;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .status {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .empty {
            padding: 20px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 600px) {
            .container {
                width: 94%;
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
            <h1>Skema Sertifikasi</h1>
            <p>Pilih skema sertifikasi yang ingin kamu ikuti.</p>
        </div>

        <a href="{{ route('user.pendaftaran') }}"
           class="btn btn-primary">
            Pendaftaran Saya
        </a>
    </div>

    <div class="card">
        @if ($skemas->count())

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Skema</th>
                        <th>Lembaga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($skemas as $skema)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $skema->kode }}</td>
                            <td>{{ $skema->nama }}</td>
                            <td>{{ $skema->lembaga ?? '-' }}</td>
                            <td>
                                @if (in_array($skema->id, $skemaTerdaftar))
                                    <span class="status">
                                        Sudah Terdaftar
                                    </span>

                                    <br>

                                    <a href="{{ route('user.pendaftaran') }}"
                                       class="btn btn-secondary"
                                       style="margin-top: 8px;">
                                        Lihat Status
                                    </a>
                                @else
                                    <a href="{{ route('user.skema.daftar', $skema->id) }}"
                                       class="btn btn-primary">
                                        Daftar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <div class="empty">
                Belum ada skema sertifikasi yang tersedia.
            </div>
        @endif
    </div>

</div>
</body>
</html>
