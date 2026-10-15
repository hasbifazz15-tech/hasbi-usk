<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Dokumen</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #222;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 24px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #222;
            text-decoration: none;
        }

        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
            white-space: nowrap;
        }

        th { background: #f8f8f8; }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #111;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #777;
        }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .card { padding: 15px; }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ route('dashboard') }}" class="back">
        &larr; Kembali ke Dashboard
    </a>

    <div class="card">
        <h1>Validasi Dokumen Peserta</h1>

        <p>Total dokumen menunggu: <strong>{{ $jumlahMenunggu }}</strong></p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Peserta</th>
                        <th>Jenis Dokumen</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dokumen as $item)
                        <tr>
                            <td>{{ $dokumen->firstItem() + $loop->index }}</td>
                            <td>{{ $item->peserta->nama ?? '-' }}</td>
                            <td>{{ $item->jenis_dokumen }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->created_at?->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.validasi.show', $item->id) }}"
                                   class="btn">
                                    Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada dokumen yang diunggah peserta.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($dokumen, 'links'))
            <div style="margin-top: 20px;">
                {{ $dokumen->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>