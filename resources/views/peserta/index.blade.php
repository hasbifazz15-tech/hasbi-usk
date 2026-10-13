<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #111827;
        }

        .container {
            width: 94%;
            max-width: 1250px;
            margin: 40px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 { margin: 0; }

        .muted {
            color: #6b7280;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .search {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search input {
            flex: 1;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .primary {
            background: #111827;
            color: white;
        }

        .detail {
            background: #6b7280;
            color: white;
        }

        .edit {
            background: #2563eb;
            color: white;
        }

        .delete {
            background: #dc2626;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 5px;
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

        .pagination {
            margin-top: 20px;
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
            <h1>Data Peserta</h1>
            <p class="muted">Kelola peserta sertifikasi.</p>
        </div>

        <a href="{{ route('peserta.create') }}" class="btn primary">
            + Tambah Peserta
        </a>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <form method="GET" action="{{ route('peserta.index') }}" class="search">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari NIK, nama, atau email..."
            >

            <button class="btn primary" type="submit">
                Cari
            </button>

            @if($search)
                <a href="{{ route('peserta.index') }}" class="btn detail">
                    Reset
                </a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Skema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pesertas as $peserta)
                    <tr>
                        <td>{{ $pesertas->firstItem() + $loop->index }}</td>
                        <td>{{ $peserta->nik }}</td>
                        <td>{{ $peserta->nama }}</td>
                        <td>{{ $peserta->email }}</td>
                        <td>{{ $peserta->skema->nama }}</td>
                        <td>{{ $peserta->status }}</td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('peserta.show', $peserta) }}"
                                    class="btn detail"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('peserta.edit', $peserta) }}"
                                    class="btn edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('peserta.destroy', $peserta) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus peserta ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn delete">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            Belum ada data peserta.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $pesertas->links() }}
        </div>

    </div>

</div>

</body>
</html>