<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Skema</title>

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
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
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

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-detail {
            background: #6b7280;
            color: white;
        }

        .btn-detail:hover {
            background: #4b5563;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .back:hover {
            color: #111827;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
                margin: 20px auto;
            }

            th, td {
                padding: 10px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ route('dashboard') }}" class="back">
        &larr; Dashboard
    </a>

    <div class="header">
        <div>
            <h1>Skema Sertifikasi</h1>
            <p>Daftar skema sertifikasi yang tersedia.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        @if($skemas->count())
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
                    @foreach($skemas as $skema)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $skema->kode }}</td>
                            <td>{{ $skema->nama }}</td>
                            <td>{{ $skema->lembaga ?? '-' }}</td>
                            <td>
                                <a href="{{ route('skema.show', $skema) }}"
                                   class="btn btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Belum ada data skema sertifikasi.</p>
        @endif
    </div>

</div>
</body>
</html>