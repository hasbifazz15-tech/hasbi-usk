<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Validasi Dokumen</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #111827;
        }

        main {
            max-width: 650px;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        h1 { margin-top: 0; }

        .info {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
            margin: 15px 0;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .value {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .catatan {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            background: #fef3c7;
            color: #92400e;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        button, .btn {
            padding: 11px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .terima { background: #15803d; }
        .tolak { background: #b91c1c; }
        .kembali { background: #374151; }

        @media (max-width: 600px) {
            body { padding: 12px; }
            .card { padding: 18px; }
        }
    </style>
</head>
<body>
<main>
    <section class="card">
        <h1>Konfirmasi Validasi</h1>
        <p>Periksa kembali keputusan sebelum disimpan.</p>

        <div class="info">
            <div class="label">Nama Peserta</div>
            <div class="value">
                {{ $dokumen->peserta->nama ?? $dokumen->peserta->nama_lengkap ?? 'Tidak tersedia' }}
            </div>
        </div>

        <div class="info">
            <div class="label">Jenis Dokumen</div>
            <div class="value">
                {{ ucfirst($dokumen->jenis_dokumen ?? '-') }}
            </div>
        </div>

        <div class="info">
            <div class="label">Keputusan yang dipilih</div>
            <div class="value">
                {{ ucfirst($data['keputusan'] ?? '-') }}
            </div>
        </div>

        @if (!empty($data['catatan_admin']))
            <div class="catatan">
                <strong>Catatan admin:</strong><br>
                {{ $data['catatan_admin'] }}
            </div>
        @endif

        <div class="actions">
            <form action="{{ route('admin.validasi.simpan-konfirmasi') }}"
                  method="POST">
                @csrf

                <button type="submit"
                        class="{{ ($data['keputusan'] ?? '') === 'diterima' ? 'terima' : 'tolak' }}"
                        onclick="return confirm('Yakin ingin menyimpan keputusan ini?')">
                    Ya, Simpan Keputusan
                </button>
            </form>

            <a class="btn kembali"
               href="{{ route('admin.validasi.show', $dokumen->id) }}">
                Kembali
            </a>
        </div>
    </section>
</main>
</body>
</html>