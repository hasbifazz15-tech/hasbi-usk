<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Status Dokumen</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px 16px;
            background: #f4f6f8;
            font-family: Arial, sans-serif;
            color: #222;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px #0000000a;
        }

        h1 { margin-top: 20px; font-size: 25px; }
        h2 { font-size: 19px; }
        .field { margin: 18px 0; }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        button, .back {
            display: inline-block;
            border: 0;
            padding: 11px 16px;
            border-radius: 7px;
            background: #222;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover, .back:hover { opacity: .85; }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 16px;
        }

        .error {
            color: #b91c1c;
            font-size: 13px;
        }

        .muted {
            color: #666;
            font-size: 13px;
        }

        .document-row {
            border-top: 1px solid #eee;
            padding: 18px 0;
        }

        .status-box {
            padding: 14px;
            border-radius: 8px;
            background: #f4f6f8;
            margin: 15px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .diterima {
            background: #dcfce7;
            color: #166534;
        }

        .ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .belum {
            background: #fef3c7;
            color: #92400e;
        }

        .terverifikasi {
            background: #dcfce7;
            color: #166534;
        }

        @media (max-width: 600px) {
            .card { padding: 17px; }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="card">

        <a class="back" href="{{ route('user.dashboard') }}">
            Kembali ke Dashboard
        </a>

        <h1>Upload & Status Dokumen</h1>

        <p class="muted">
            Format PDF, JPG, JPEG, atau PNG. Maksimal 5 MB per file.
        </p>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @forelse ($pesertas as $peserta)
            <div class="document-row">
                <h2>{{ $peserta->nama }}</h2>

                <p>
                    Skema:
                    {{ $peserta->skema?->nama_skema ?? $peserta->skema?->nama ?? '-' }}
                </p>

                {{-- Status verifikasi keseluruhan --}}
                <div class="status-box">
                    <strong>Status Verifikasi Peserta:</strong><br>

                    @if ($peserta->status_verifikasi === 'Terverifikasi')
                        <span class="badge terverifikasi">
                            Terverifikasi
                        </span>
                    @else
                        <span class="badge belum">
                            Belum Terverifikasi
                        </span>
                    @endif

                    <p class="muted">
                        Status menjadi terverifikasi setelah semua dokumen
                        peserta diterima oleh admin.
                    </p>
                </div>

                <form
                    action="{{ route('user.dokumen.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="peserta_id"
                        value="{{ $peserta->id }}"
                    >

                    @foreach ([
                        'ktp' => 'KTP',
                        'ijazah' => 'Ijazah',
                        'sertifikat' => 'Sertifikat'
                    ] as $jenis => $label)

                        @php
                            $dokumen = $peserta->dokumenPesertas
                                ->where('jenis_dokumen', $jenis)
                                ->sortByDesc('id')
                                ->first();
                        @endphp

                        <div class="field">
                            <label for="{{ $jenis }}-{{ $peserta->id }}">
                                {{ $label }}
                            </label>

                            <input
                                id="{{ $jenis }}-{{ $peserta->id }}"
                                type="file"
                                name="dokumen[{{ $jenis }}]"
                                accept=".pdf,.jpg,.jpeg,.png"
                            >

                            @if ($dokumen)
                                <p>
                                    Status dokumen:
                                    <span class="badge {{ $dokumen->status }}">
                                        {{ ucfirst($dokumen->status) }}
                                    </span>
                                </p>

                                @if ($dokumen->catatan_admin)
                                    <p class="error">
                                        Catatan admin:
                                        {{ $dokumen->catatan_admin }}
                                    </p>
                                @endif

                                @if ($dokumen->status === 'ditolak')
                                    <p class="muted">
                                        Silakan unggah dokumen pengganti yang benar.
                                    </p>
                                @endif
                            @else
                                <p class="muted">
                                    Belum ada dokumen yang diunggah.
                                </p>
                            @endif
                        </div>
                    @endforeach

                    <button type="submit">
                        Upload Dokumen
                    </button>
                </form>
            </div>
        @empty
            <p>
                Belum ada pendaftaran yang cocok dengan email akun lu.
                Daftar skema terlebih dahulu.
            </p>
        @endforelse

    </div>
</div>
</body>
</html>