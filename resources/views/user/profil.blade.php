<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #111827;
        }

        main { max-width: 700px; margin: 30px auto; }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        h1 { margin-bottom: 20px; }
        h2 { margin-top: 0; }

        label {
            display: block;
            margin: 15px 0 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        input[type="file"] { background: #f9fafb; }

        button, .btn {
            display: inline-block;
            margin-top: 18px;
            padding: 11px 15px;
            border: none;
            border-radius: 6px;
            background: #111827;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .success {
            color: #166534;
            background: #dcfce7;
            padding: 12px;
            border-radius: 6px;
        }

        .errors {
            color: #991b1b;
            background: #fee2e2;
            padding: 12px 25px;
            border-radius: 6px;
        }

        .hint {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .menunggu { color: #92400e; background: #fef3c7; }
        .diterima { color: #166534; background: #dcfce7; }
        .ditolak { color: #991b1b; background: #fee2e2; }
        .belum { color: #374151; background: #e5e7eb; }

        .dokumen-item {
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .dokumen-item:last-child { border-bottom: none; }
        .dokumen-item p { margin: 8px 0; }

        @media (max-width: 600px) {
            body { padding: 12px; }
            .card { padding: 18px; }
        }
    </style>
</head>

<body>
<main>
    <a class="btn" href="{{ route('user.dashboard') }}">
        &larr; Kembali ke Dashboard
    </a>

    <h1>Profil Saya</h1>

    @if (session('profile_success'))
        <p class="success">{{ session('profile_success') }}</p>
    @endif

    @if (session('password_success'))
        <p class="success">{{ session('password_success') }}</p>
    @endif

    @if ($errors->any())
        <div class="errors">
            <strong>Periksa kembali data kamu:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$peserta)
        <section class="card">
            <p>Data peserta belum ditemukan. Silakan daftar skema terlebih dahulu.</p>
        </section>
    @else
        <form action="{{ route('user.profil.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <section class="card">
                <h2>Data Diri</h2>

                <label for="name">Nama lengkap</label>
                <input id="name" name="name"
                       value="{{ old('name', $user->name) }}" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $user->email) }}" required>

                <label for="nik">NIK (16 digit)</label>
                <input id="nik" name="nik" type="text"
                       inputmode="numeric" maxlength="16"
                       pattern="[0-9]{16}"
                       value="{{ old('nik', $peserta->nik) }}"
                       placeholder="Masukkan 16 digit NIK" required>

                <label for="no_hp">Nomor HP</label>
                <input id="no_hp" name="no_hp" type="text"
                       value="{{ old('no_hp', $peserta->no_hp) }}">
            </section>

            <section class="card">
                <h2>Dokumen Peserta</h2>

                <p class="hint">
                    Format PDF, JPG, JPEG, atau PNG. Maksimal 2 MB per file.
                    Pilih file hanya jika ingin mengunggah atau mengganti dokumen.
                </p>

                @php
                    $jenisDokumen = [
                        'ktp' => 'Foto / Scan KTP',
                        'ijazah' => 'Ijazah Terakhir',
                        'sertifikat' => 'Sertifikat Pendukung',
                    ];
                @endphp

                @foreach ($jenisDokumen as $jenis => $nama)
                    @php
                        $dokumen = $peserta->dokumenPesertas
                            ->where('jenis_dokumen', $jenis)
                            ->sortByDesc('id')
                            ->first();

                        $status = $dokumen->status ?? 'belum';
                    @endphp

                    <div class="dokumen-item">
                        <label for="{{ $jenis }}">{{ $nama }}</label>

                        @if ($dokumen && $dokumen->file_path)
                            <p class="hint">
                                Dokumen sudah diunggah.
                            </p>
                        @else
                            <p class="hint">
                                Dokumen belum diunggah.
                            </p>
                        @endif

                        <input id="{{ $jenis }}"
                               name="{{ $jenis }}"
                               type="file"
                               accept=".pdf,.jpg,.jpeg,.png">

                        <p>
                            Status:

                            @if ($status === 'diterima')
                                <span class="status diterima">Diterima</span>
                            @elseif ($status === 'ditolak')
                                <span class="status ditolak">Ditolak</span>
                            @elseif ($status === 'menunggu')
                                <span class="status menunggu">Menunggu Verifikasi</span>
                            @else
                                <span class="status belum">Belum Diunggah</span>
                            @endif
                        </p>

                        @if ($dokumen && $dokumen->catatan_admin)
                            <p class="hint">
                                Catatan admin: {{ $dokumen->catatan_admin }}
                            </p>
                        @endif
                    </div>
                @endforeach

                <p class="hint">
                    Jika dokumen ditolak, unggah ulang file yang benar.
                    Status akan kembali menjadi menunggu verifikasi.
                </p>
            </section>

            <section class="card">
                <h2>Status Verifikasi</h2>

                @if (($peserta->status_verifikasi ?? '') === 'Terverifikasi')
                    <span class="status diterima">Terverifikasi</span>
                @else
                    <span class="status belum">Belum Terverifikasi</span>
                @endif

                <p class="hint">
                    Status menjadi Terverifikasi setelah semua dokumen
                    diterima oleh admin.
                </p>
            </section>

            <button type="submit">Simpan Profil &amp; Dokumen</button>
        </form>
    @endif
</main>
</body>
</html>