<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,.08);
        }

        h1 {
            margin-top: 0;
        }

        .data {
            margin-top: 20px;
        }

        .row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .label {
            width: 180px;
            font-weight: bold;
        }

        .value {
            flex: 1;
        }

        .buttons {
            margin-top: 25px;
        }

        a {
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 6px;
            margin-right: 5px;
        }

        .back {
            background: #ddd;
            color: #222;
        }

        .edit {
            background: #222;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Detail Peserta</h1>

    <div class="data">

        <div class="row">
            <div class="label">NIK</div>
            <div class="value">{{ $peserta->nik }}</div>
        </div>

        <div class="row">
            <div class="label">Nama</div>
            <div class="value">{{ $peserta->nama }}</div>
        </div>

        <div class="row">
            <div class="label">Email</div>
            <div class="value">{{ $peserta->email }}</div>
        </div>

        <div class="row">
            <div class="label">No. HP</div>
            <div class="value">{{ $peserta->no_hp }}</div>
        </div>

        <div class="row">
            <div class="label">Alamat</div>
            <div class="value">{{ $peserta->alamat }}</div>
        </div>

        <div class="row">
            <div class="label">Skema</div>
            <div class="value">
                {{ $peserta->skema->kode }} - {{ $peserta->skema->nama }}
            </div>
        </div>

        <div class="row">
            <div class="label">Lembaga</div>
            <div class="value">{{ $peserta->skema->lembaga ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="label">Tanggal Daftar</div>
            <div class="value">
                {{ $peserta->tanggal_daftar->format('d-m-Y') }}
            </div>
        </div>

        <div class="row">
            <div class="label">Status</div>
            <div class="value">{{ $peserta->status }}</div>
        </div>

    </div>

    <div class="buttons">
        <a href="{{ route('peserta.index') }}" class="back">Kembali</a>

        <a href="{{ route('peserta.edit', $peserta) }}" class="edit">
            Edit Peserta
        </a>
    </div>

</div>

</body>
</html>