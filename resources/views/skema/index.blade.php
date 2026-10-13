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

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #111827;
            color: white;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .btn-detail {
            background: #6b7280;
            color: white;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
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

        .actions {
            display: flex;
            gap: 6px;
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
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('dashboard') }}" class="back">
        ← Dashboard
    </a>

    <div class="header">
        <div>
            <h1>Skema Sertifikasi</h1>
            <p>Kelola data skema sertifikasi.</p>
        </div>

        <a href="{{ route('skema.create') }}" class="btn btn-primary">
            + Tambah Skema
        </a>
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
                                <div class="actions">

                                    <a href="{{ route('skema.show', $skema) }}"
                                       class="btn btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('skema.edit', $skema) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('skema.destroy', $skema) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus skema ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else

            <p>Belum ada data skema sertifikasi.</p>

        @endif

    </div>

</div>

</body>
</html>