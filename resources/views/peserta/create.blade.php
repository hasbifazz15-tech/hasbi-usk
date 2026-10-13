<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peserta</title>

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
            max-width: 800px;
            margin: 40px auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        h1 {
            margin-top: 0;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-family: inherit;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .btn {
            padding: 11px 18px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .primary {
            background: #111827;
            color: white;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('peserta.index') }}" class="back">
        ← Kembali
    </a>

    <div class="card">

        <h1>Tambah Peserta</h1>

        <p class="subtitle">
            Masukkan data peserta sertifikasi.
        </p>

        @if($errors->any())
            <div class="errors">
                <strong>Periksa kembali data:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peserta.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nik">NIK</label>

                <input
                    type="text"
                    id="nik"
                    name="nik"
                    value="{{ old('nik') }}"
                    maxlength="16"
                    inputmode="numeric"
                    placeholder="Masukkan 16 digit NIK"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Nama lengkap peserta"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                >
            </div>

            <div class="form-group">
               
<label>No. HP</label>
<input type="text" name="no_hp" value="{{ old('no_hp') }}">

<small id="peringatan-hp" style="color: #b45309; display: none;">
    Peringatan: nomor HP kurang dari 10 digit. Pastikan nomor sudah benar.
</small>

@error('no_hp')
    <div style="color: red;">{{ $message }}</div>
@enderror

            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>

                <textarea
                    id="alamat"
                    name="alamat"
                    placeholder="Alamat lengkap peserta"
                    required
                >{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label for="skema_id">Skema Sertifikasi</label>

                <select id="skema_id" name="skema_id" required>
                    <option value="">-- Pilih Skema --</option>

                    @foreach($skemas as $skema)
                        <option
                            value="{{ $skema->id }}"
                            {{ old('skema_id') == $skema->id ? 'selected' : '' }}
                        >
                            {{ $skema->kode }} - {{ $skema->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_daftar">Tanggal Daftar</label>

                <input
                    type="date"
                    id="tanggal_daftar"
                    name="tanggal_daftar"
                    value="{{ old('tanggal_daftar', date('Y-m-d')) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status" required>
                    <option value="Terdaftar"
                        {{ old('status', 'Terdaftar') == 'Terdaftar' ? 'selected' : '' }}>
                        Terdaftar
                    </option>

                    <option value="Proses"
                        {{ old('status') == 'Proses' ? 'selected' : '' }}>
                        Proses
                    </option>

                    <option value="Lulus"
                        {{ old('status') == 'Lulus' ? 'selected' : '' }}>
                        Lulus
                    </option>

                    <option value="Tidak Lulus"
                        {{ old('status') == 'Tidak Lulus' ? 'selected' : '' }}>
                        Tidak Lulus
                    </option>
                </select>
            </div>

            <button type="submit" class="btn primary">
                Simpan Peserta
            </button>

        </form>

    </div>

</div>

</body>
</html>