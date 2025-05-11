<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1>Selamat Datang di {{ config('app.name', 'Laravel') }}</h1>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary mx-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success mx-2">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
