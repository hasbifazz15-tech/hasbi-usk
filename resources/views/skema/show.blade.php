<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skema</title>

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
            max-width: 800px;
            width: 90%;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .row {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #374151;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('skema.index') }}" class="back">
        ← Kembali
    </a>

    <div class="card">

        <h1>{{ $skema->nama }}</h1>

        <div class="row">
            <div class="label">Kode</div>
            <div>{{ $skema->kode }}</div>
        </div>

        <div class="row">
            <div class="label">Lembaga</div>
            <div>{{ $skema->lembaga ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="label">Deskripsi</div>
            <div>{{ $skema->deskripsi ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="label">Jumlah Peserta</div>
            <div>{{ $skema->pesertas()->count() }} peserta</div>
        </div>

    </div>

</div>

</body>
</html>