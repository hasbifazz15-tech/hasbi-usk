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
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #111827;
            color: white;
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

        .errors ul {
            margin: 0;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('skema.index') }}" class="back">
        ← Kembali
    </a>

    <div class="card">

        <h1>Edit Skema</h1>

        @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('skema.update', $skema) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Kode Skema</label>
            <input
                type="text"
                name="kode"
                value="{{ old('kode', $skema->kode) }}"
                required
            >

            <label>Nama Skema</label>
            <input
                type="text"
                name="nama"
                value="{{ old('nama', $skema->nama) }}"
                required
            >

            <label>Deskripsi</label>
            <textarea name="deskripsi">{{ old('deskripsi', $skema->deskripsi) }}</textarea>

            <label>Lembaga</label>
            <input
                type="text"
                name="lembaga"
                value="{{ old('lembaga', $skema->lembaga) }}"
            >

            <button type="submit" class="btn btn-primary">
                Update Skema
            </button>

        </form>

    </div>

</div>

</body>
</html>