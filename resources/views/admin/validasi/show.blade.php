<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Validasi Dokumen</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        h2 {
            margin-top: 0;
        }

        .info {
            margin: 14px 0;
            overflow-wrap: anywhere;
        }

        .label {
            display: inline-block;
            width: 150px;
            color: #666;
            vertical-align: top;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
        }

        .status-diterima {
            background: #dcfce7;
            color: #166534;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .preview {
            display: block;
            width: 100%;
            max-height: 700px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 15px;
            background: #f9fafb;
        }

        .preview-pdf {
            width: 100%;
            height: 650px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 15px;
        }

        textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button, .btn {
            display: inline-block;
            padding: 11px 16px;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        button {
            background: #222;
            color: white;
        }

        button:hover, .btn:hover {
            opacity: .85;
        }

        .btn-back {
            background: #e5e7eb;
            color: #222;
        }

        .btn-file {
            background: #222;
            color: white;
            margin-top: 12px;
        }

        .error {
            color: #c62828;
            margin-top: 6px;
        }

        .notice {
            padding: 12px;
            background: #fef3c7;
            border-radius: 7px;
            margin: 18px 0;
            line-height: 1.5;
        }

        .empty-file {
            padding: 25px;
            text-align: center;
            background: #f9fafb;
            border: 1px dashed #ccc;
            border-radius: 8px;
            color: #666;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .card {
                padding: 17px;
            }

            .label {
                display: block;
                width: auto;
                margin-bottom: 5px;
            }

            .preview-pdf {
                height: 450px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    {{-- INFORMASI PESERTA --}}
    <div class="card">
        <a href="{{ route('admin.validasi.index') }}"
           class="btn btn-back">
            &larr; Kembali
        </a>

        <h2 style="margin-top: 20px;">Detail Validasi Dokumen</h2>

        <div class="info">
            <span class="label">Nama peserta</span>
            <strong>{{ $dokumen->peserta->nama ?? '-' }}</strong>
        </div>

        <div class="info">
            <span class="label">Email</span>
            {{ $dokumen->peserta->email ?? '-' }}
        </div>

        <div class="info">
            <span class="label">Jenis dokumen</span>
            {{ strtoupper($dokumen->jenis_dokumen ?? '-') }}
        </div>

        <div class="info">
            <span class="label">Tanggal upload</span>
            {{ $dokumen->created_at?->format('d-m-Y H:i') ?? '-' }}
        </div>

        <div class="info">
            <span class="label">Status</span>

            <span class="status
                {{ strtolower($dokumen->status ?? '') === 'diterima' ? 'status-diterima' : '' }}
                {{ strtolower($dokumen->status ?? '') === 'ditolak' ? 'status-ditolak' : '' }}">
                {{ ucfirst($dokumen->status ?? 'menunggu') }}
            </span>
        </div>
    </div>

    {{-- PREVIEW DOKUMEN --}}
    <div class="card">
        <h2>File Dokumen</h2>

        @php
            $urlDokumen = route(
                'admin.validasi.file',
                ['dokumen' => $dokumen->id]
            );

            $ekstensi = strtolower(
                pathinfo($dokumen->file_path ?? '', PATHINFO_EXTENSION)
            );

            $formatGambar = in_array(
                $ekstensi,
                ['jpg', 'jpeg', 'png', 'webp']
            );

            $formatPdf = $ekstensi === 'pdf';
        @endphp

        @if (empty($dokumen->file_path))

            <div class="empty-file">
                File dokumen belum tersedia.
            </div>

        @elseif ($formatGambar)

            <img
                src="{{ $urlDokumen }}"
                alt="Foto dokumen peserta"
                class="preview"
                onerror="this.style.display='none'; document.getElementById('gambar-gagal').style.display='block';"
            >

            <div id="gambar-gagal"
                 class="empty-file"
                 style="display:none;">
                Gambar gagal dimuat. File mungkin tidak ditemukan
                atau tidak dapat dibaca oleh server.
                <br>
                <a href="{{ $urlDokumen }}"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-file">
                    Coba buka foto
                </a>
            </div>

            <p>
                <a href="{{ $urlDokumen }}"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-file">
                    Buka foto di tab baru
                </a>
            </p>

        @elseif ($formatPdf)

            <iframe
                src="{{ $urlDokumen }}"
                class="preview-pdf"
                title="Pratinjau dokumen PDF">
            </iframe>

            <a href="{{ $urlDokumen }}"
               target="_blank"
               rel="noopener"
               class="btn btn-file">
                Buka PDF di tab baru
            </a>

        @else

            <div class="empty-file">
                Pratinjau tidak tersedia untuk format
                <strong>{{ $ekstensi ?: 'tidak diketahui' }}</strong>.
            </div>

            <a href="{{ $urlDokumen }}"
               target="_blank"
               rel="noopener"
               class="btn btn-file">
                Buka dokumen
            </a>

        @endif
    </div>

    {{-- KEPUTUSAN ADMIN --}}
    <div class="card">
        <h2>Keputusan Admin</h2>

        @if (strtolower($dokumen->status ?? '') === 'menunggu')

            <form
                action="{{ route('admin.validasi.keputusan', ['dokumen' => $dokumen->id]) }}"
                method="POST">

                @csrf

                <label for="keputusan">Keputusan</label>

                <select name="keputusan" id="keputusan" required>
                    <option value="">-- Pilih keputusan --</option>

                    <option value="diterima"
                        {{ old('keputusan') === 'diterima' ? 'selected' : '' }}>
                        Terima dokumen
                    </option>

                    <option value="ditolak"
                        {{ old('keputusan') === 'ditolak' ? 'selected' : '' }}>
                        Tolak dokumen
                    </option>
                </select>

                @error('keputusan')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="catatan_admin"
                       style="display:block; margin-top:18px;">
                    Catatan / alasan penolakan
                </label>

                <textarea
                    name="catatan_admin"
                    id="catatan_admin"
                    maxlength="1000"
                    placeholder="Tuliskan alasan jika dokumen ditolak...">{{ old('catatan_admin') }}</textarea>

                @error('catatan_admin')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="notice">
                    Periksa dokumen terlebih dahulu. Setelah memilih
                    keputusan, lu akan diarahkan ke halaman konfirmasi
                    sebelum keputusan disimpan.
                </div>

                <button type="submit">Lanjutkan Konfirmasi</button>
            </form>

        @else

            <p>Dokumen ini sudah divalidasi.</p>

            <div class="info">
                <span class="label">Catatan admin</span>
                {{ $dokumen->catatan_admin ?: '-' }}
            </div>

            <div class="info">
                <span class="label">Waktu validasi</span>
                {{ $dokumen->diverifikasi_pada?->format('d-m-Y H:i') ?? '-' }}
            </div>

        @endif
    </div>

</div>
</body>
</html>