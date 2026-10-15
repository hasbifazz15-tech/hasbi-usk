<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Skema</title>

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
            max-width: 700px;
            width: 90%;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            margin-bottom: 18px;
            font-family: inherit;
            font-size: 14px;
        }

        input:focus, textarea:focus {
            outline: 2px solid #9ca3af;
            border-color: #6b7280;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input[type="file"] {
            background: #f9fafb;
        }

        .preview {
            margin-bottom: 18px;
        }

        .preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            display: block;
            margin-bottom: 10px;
        }

        .help {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary {
            background: #111827;
            color: white;
        }

        .btn-primary:hover {
            background: #374151;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 500px) {
            .container {
                margin: 20px auto;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('skema.index') }}" class="back">
        &larr; Kembali ke Daftar Skema
    </a>

    <div class="card">

        <h1>Edit Skema</h1>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="errors">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('skema.update', $skema) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <label for="kode">Kode Skema</label>
            <input
                type="text"
                id="kode"
                name="kode"
                value="{{ old('kode', $skema->kode) }}"
                required
            >

            <label for="nama">Nama Skema</label>
            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama', $skema->nama) }}"
                required
            >

            <label for="deskripsi">Deskripsi</label>
            <textarea
                id="deskripsi"
                name="deskripsi"
            >{{ old('deskripsi', $skema->deskripsi) }}</textarea>

            <label for="lembaga">Lembaga</label>
            <input
                type="text"
                id="lembaga"
                name="lembaga"
                value="{{ old('lembaga', $skema->lembaga) }}"
            >

            <label>Foto / Logo Skema Saat Ini</label>

            <div class="preview">
                @if($skema->foto)
                    <img
                        src="{{ asset('storage/' . $skema->foto) }}"
                        alt="Foto skema saat ini"
                    >
                    <small>Foto yang tersimpan sekarang.</small>
                @else
                    <p>Belum ada foto untuk skema ini.</p>
                @endif
            </div>

            <label for="foto">Upload Foto / Logo Baru</label>
            <input
                type="file"
                id="foto"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <small class="help">
                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                Kosongkan jika tidak ingin mengganti foto.
            </small>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

            <a href="{{ route('skema.index') }}"
               class="btn"
               style="background:#e5e7eb;color:#111827;">
                Batal
            </a>

        </form>

    </div>

</div>

</body>
</html>