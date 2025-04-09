<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style> 
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .top-bar {
        background: #00487C;
        color: white;
        padding: 15px 0;
        font-size: 16px;
    }

    .top-bar .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .top-bar .right a {
        color: white;
        text-decoration: none;
        margin-left: 10px;
        padding: 5px 15px;
        border-radius: 5px;
        font-size: 14px;
        background: none;
        border: 2px solid white;
    }

    .top-bar .right .btn-login,
    .top-bar .right .btn-register {
        background: white;
        color: #0D1C3F;
        border: 2px solid #0D1C3F;
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
    }

    .top-bar .right .btn-register {
        margin-left: 10px;
    }

    .top-bar .right .btn-login:hover,
    .top-bar .right .btn-register:hover {
        background: #0D1C3F;
        color: white;
    }

    .menu-container {
        background: #fff;
        color: #00487C;
        display: flex;
        justify-content: space-between;
        padding: 30px 50px;
        align-items: center;
    }

    .menu-container .logo {
        font-size: 28px;
        font-weight: bold;
        font-style: italic;
    }

    .menu-container .menu a {
        color: #00487C;
        text-decoration: none;
        margin-left: 15px;
        font-weight: bold;
    }

    .hero {
        text-align: center;
        padding: 50px 0;
        background: #ffffff;
    }

    .hero h1 {
        font-size: 32px;
        font-weight: bold;
    }

    .register-form {
        width: 500px;
        margin: 30px auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        text-align: left;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: none;
        background: #D9D9D9;
        border-radius: 30px;
        font-size: 16px;
        text-align: center;
        outline: none;
    }
    .remember-me {
    display: flex;
    align-items: center;
    gap: 8px; 
    }

    .btn-primary {
        background: #007bff;
        color: white;
        padding: 12px;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 30px;
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
    }

    footer {
        background: #00487C;
        color: white;
        padding: 30px 0;
        text-align: justify;
    }

    .footer-info {
        display: flex;
        justify-content: space-around;
        max-width: 900px;
        margin: 0 auto;
        gap: 250px
    }

    .footer-info div {
        max-width: 400px;
    }

    .footer-info h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }


</style>
<body>

    <div class="top-bar">
        <div class="container">
            <div class="left">
                <span>📞 Phone: +62 812345678</span>
                <span>📧 Email: almadalaundry@gmail.com</span>
            </div>
            <div class="right">
                <a href="{{ route('login') }}" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
            </div>
        </div>
    </div>

    <nav class="menu-container">
        <div class="logo"><b>ALMADA LAUNDRY</b></div>
        <div class="menu">
            <a href="#">HOME</a>
            <a href="#">ABOUT US</a>
            <a href="#">SERVICES</a>
            <a href="#">PRICING</a>
            <a href="#">CONTACT</a>
        </div>
    </nav>

    <div class="hero">
    <h1><b>REGISTER</b></h1>
    <div class="register-form">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn-primary">Register</button>
        </form>
    </div>
</div>

    <footer>
        <div class="container">
            <div class="footer-info">
                <div>
                    <h3><i><b>ALMADA LAUNDRY</b></i></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div>
                    <h3><b>Get In Touch</b></h3>
                    <p>📞 Phone: +62 812345678</p>
                    <p>📧 Email: almadalaundry@gmail.com</p>
                    <p>🌐 Website: www.almadalaundry.com</p>
                    <p>📍 Address: Jl. Sampangan No.92, Semanggi, Surakarta</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
