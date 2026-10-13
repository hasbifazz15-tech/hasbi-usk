<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
            max-width: 1100px;
            margin: 40px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            margin: 0;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 5px;
        }

        .logout {
            background: #dc2626;
            color: white;
            border: 0;
            padding: 10px 16px;
            border-radius: 7px;
            cursor: pointer;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .card h2 {
            margin-top: 0;
        }

        .card p {
            color: #6b7280;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 16px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

        @media (max-width: 600px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Dashboard</h1>

            <div class="subtitle">
                Selamat datang, {{ auth()->user()->name }}
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="logout" type="submit">
                Logout
            </button>
        </form>
    </div>


    <div class="cards">

        <div class="card">
            <h2>Skema Sertifikasi</h2>

            <p>
                Kelola data skema sertifikasi yang tersedia.
            </p>

            <a href="{{ route('skema.index') }}" class="btn">
                Kelola Skema
            </a>
        </div>


        <div class="card">
            <h2>Data Peserta</h2>

            <p>
                Kelola data peserta sertifikasi.
            </p>

            <a href="{{ route('peserta.index') }}" class="btn">
                Kelola Peserta
            </a>
        </div>

    </div>

</div>

</body>
</html>