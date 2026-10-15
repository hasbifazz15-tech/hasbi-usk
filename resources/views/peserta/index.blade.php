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

        h1 { margin-top: 0; }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
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

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .verified {
            background: #dcfce7;
            color: #166534;
        }

        .unverified {
            background: #fef3c7;
            color: #92400e;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #111;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #222;
            text-decoration: none;
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
        <h1>Data Peserta</h1>

        <p class="subtitle">
            Daftar peserta sertifikasi dan status verifikasi dokumennya.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Skema</th>
                        <th>Status Peserta</th>
                        <th>Status Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesertas as $peserta)
                        <tr>
                            <td>{{ $pesertas->firstItem() + $loop->index }}</td>

                            <td>{{ $peserta->nama }}</td>

                            <td>{{ $peserta->email }}</td>

                            <td>
                                {{ $peserta->skema->nama_skema ?? '-' }}
                            </td>

                            <td>
                                {{ $peserta->status ?? '-' }}
                            </td>

                            <td>
                                @php
                                    $dokumen = $peserta->dokumenPesertas ?? collect();

                                    $semuaTerverifikasi = $dokumen->isNotEmpty()
                                        && $dokumen->every(fn ($item) => $item->status === 'Terverifikasi');
                                @endphp

                                @if ($dokumen->isEmpty())
                                    <span class="badge unverified">
                                        Belum Upload
                                    </span>
                                @elseif ($semuaTerverifikasi)
                                    <span class="badge verified">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="badge unverified">
                                        Belum Lengkap / Diproses
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('peserta.show', $peserta->id) }}"
                                   class="btn">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                Belum ada data peserta.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($pesertas, 'links'))
            <div style="margin-top: 20px;">
                {{ $pesertas->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>