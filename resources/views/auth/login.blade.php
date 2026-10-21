<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BPS Provinsi Papua</title>
    <link rel="stylesheet" href="{{ asset('assets/bps.css') }}">
</head>
<body class="halaman-login">
    <main class="login-konten">
        <section class="login-box">
            <img src="{{ asset('assets/BPS.png') }}" alt="Logo BPS" class="logo-login">
            <h1>Login BPS Provinsi Papua</h1>

            @if ($errors->any())
                <p id="pesanError" style="display:block">{{ $errors->first() }}</p>
            @endif

            <form class="form-login" action="{{ route('login.store') }}" method="post">
                @csrf

                <div class="field-login">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="field-login">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Login</button>
            </form>
        </section>
    </main>
</body>
</html>
