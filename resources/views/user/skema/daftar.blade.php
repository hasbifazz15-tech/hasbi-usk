<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Sertifikasi</title>

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
            width: 92%;
            max-width: 700px;
            margin: 35px auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .card {
            background: white;
            padding: 28px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .04);
        }

        h1 {
            margin: 0 0 10px;
        }

        .description {
            color: #6b7280;
            line-height: 1.6;
        }

        .info {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin: 22px 0;
            line-height: 1.7;
        }

        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
        }

        input:focus, textarea:focus {
            outline: 2px solid #9ca3af;
            border-color: #6b7280;
        }

        input[readonly] {
            background: #f3f4f6;
            color: #4b5563;
        }

        .hint {
            margin-top: 6px;
            color: #6b7280;
            font-size: 12px;
        }

        .error {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 13px;
        }

        .alert {
            padding: 13px;
            margin: 18px 0;
            border-radius: 7px;
            line-height: 1.5;
        }

        .alert-error {
            color: #991b1b;
            background: #fee2e2;
        }

        .alert-success {
            color: #166534;
            background: #dcfce7;
        }

        .btn {
            display: inline-block;
            padding: 12px 17px;
            border: 0;
            border-radius: 7px;
            background: #111827;
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background: #374151;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        @media (max-width: 500px) {
            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <a href="{{ route('user.skema.index') }}" class="back">
        &larr; Kembali ke Daftar Skema
    </a>

    <div class="card">
        <h1>Form Pendaftaran</h1>
        <p class="description">
            Lengkapi data berikut untuk mendaftar sertifikasi.
        </p>

        <div class="info">
            <strong>Informasi Skema</strong><br>
            Kode: {{ $skema->kode }}<br>
            Nama: {{ $skema->nama }}<br>
            Lembaga: {{ $skema->lembaga ?? '-' }}<br>
            Deskripsi: {{ $skema->deskripsi ?? '-' }}
        </div>

        {{-- Pesan error dan sukses --}}
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validasi umum --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Periksa kembali data kamu:</strong>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($sudahDaftar)
            <div class="alert alert-error">
                Kamu sudah terdaftar pada skema ini.
                Silakan pilih skema sertifikasi lain.
            </div>

            <a href="{{ route('user.pendaftaran') }}" class="btn">
                Lihat Pendaftaran Saya
            </a>

            <a href="{{ route('user.skema.index') }}"
               class="btn btn-secondary">
                Pilih Skema Lain
            </a>
        @else

            <form action="{{ route('user.pendaftaran.store') }}" method="POST">
                @csrf

                <input
                    type="hidden"
                    name="skema_id"
                    value="{{ $skema->id }}"
                >

                <label for="nama">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    value="{{ auth()->user()->name }}"
                    readonly
                >

                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    value="{{ auth()->user()->email }}"
                    readonly
                >

                <label for="nik">NIK</label>
                <input
                    type="text"
                    id="nik"
                    name="nik"
                    value="{{ old('nik') }}"
                    inputmode="numeric"
                    minlength="16"
                    maxlength="16"
                    pattern="[0-9]{16}"
                    placeholder="Masukkan 16 digit NIK"
                    required
                >
                <p class="hint">NIK harus terdiri dari 16 digit angka.</p>
                @error('nik')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="no_hp">Nomor HP</label>
                <input
                    type="tel"
                    id="no_hp"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    inputmode="numeric"
                    minlength="10"
                    maxlength="15"
                    pattern="[0-9]{10,15}"
                    placeholder="Contoh: 081234567890"
                    required
                >
                <p class="hint">Masukkan 10–15 digit angka.</p>
                @error('no_hp')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="alamat">Alamat Lengkap</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="4"
                    maxlength="1000"
                    placeholder="Masukkan alamat lengkap"
                    required
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="error">{{ $message }}</div>
                @enderror

                @error('skema_id')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="actions">
                    <button type="submit" class="btn">
                        Kirim Pendaftaran
                    </button>

                    <a href="{{ route('user.skema.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        @endif
    </div>

</div>
</body>
</html>