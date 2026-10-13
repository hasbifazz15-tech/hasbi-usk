<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,.08);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .error {
            color: #d00;
            font-size: 14px;
            margin-top: 5px;
        }

        .buttons {
            margin-top: 25px;
        }

        button, a {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #222;
            color: white;
        }

        .back {
            background: #ddd;
            color: #222;
            margin-left: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Peserta</h1>

    <form action="{{ route('peserta.update', ['peserta' => $peserta->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>NIK</label>
        <input type="text" name="nik"
               value="{{ old('nik', $peserta->nik) }}"
               maxlength="16">
        @error('nik')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Nama</label>
        <input type="text" name="nama"
               value="{{ old('nama', $peserta->nama) }}">
        @error('nama')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email', $peserta->email) }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>No. HP</label>
        <input type="text" name="no_hp"
               value="{{ old('no_hp', $peserta->no_hp) }}">
        @error('no_hp')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat', $peserta->alamat) }}</textarea>
        @error('alamat')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Skema Sertifikasi</label>
        <select name="skema_id">
            <option value="">-- Pilih Skema --</option>

            @foreach ($skemas as $skema)
                <option value="{{ $skema->id }}"
                    {{ old('skema_id', $peserta->skema_id) == $skema->id ? 'selected' : '' }}>
                    {{ $skema->kode }} - {{ $skema->nama }}
                </option>
            @endforeach
        </select>

        @error('skema_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Tanggal Daftar</label>
        <input type="date" name="tanggal_daftar"
               value="{{ old('tanggal_daftar', $peserta->tanggal_daftar->format('Y-m-d')) }}">
        @error('tanggal_daftar')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Status</label>
        <select name="status">
            @foreach (['Terdaftar', 'Proses', 'Lulus', 'Tidak Lulus'] as $status)
                <option value="{{ $status }}"
                    {{ old('status', $peserta->status) == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror

        <div class="buttons">
            <button type="submit">Simpan Perubahan</button>

            <a href="{{ route('peserta.index') }}" class="back">
                Batal
            </a>
        </div>

    </form>

</div>

</body>
</html>