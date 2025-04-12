<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services - Almada Laundry</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .top-bar {
            background-color: #0a3b63;
            color: white;
            font-size: 12px;
            padding: 5px 0;
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .top-bar .left span {
            margin-right: 15px;
        }

        .top-bar .right a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
            border: 1px solid white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        nav.menu-container {
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 22px;
            color: #0a3b63;
            font-weight: bold;
        }

        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #0a3b63;
            font-weight: bold;
            padding: 8px 12px;
        }

        .menu a:hover, .menu a.active {
            background-color: #d0e2f2;
            border-radius: 4px;
        }

        .hero {
            background: url('/mnt/data/image.png') no-repeat center center;
            background-size: cover;
            height: 200px;
            position: relative;
        }

        .hero h1 {
            position: absolute;
            bottom: 10px;
            right: 20px;
            color: #0a3b63;
            font-size: 28px;
        }

        .breadcrumb {
            position: absolute;
            bottom: -10px;
            right: 20px;
            color: #0a3b63;
            font-size: 12px;
        }

        .section {
            padding: 40px 20px;
            text-align: center;
        }

        .section h2 {
            color: #0a3b63;
            margin-bottom: 10px;
        }

        footer {
            background-color: #0a3b63;
            color: white;
            padding: 40px 20px;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
            flex-wrap: wrap;
        }

        .footer-info div {
            width: 45%;
            margin-bottom: 20px;
        }

        .footer-info p {
            font-size: 13px;
            margin: 5px 0;
        }

        .footer-icons {
            margin-top: 15px;
        }

        .footer-icons i {
            font-size: 18px;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="container">
            <div class="left">
                <span>📞 Phone: +62 812345678</span>
                <span>📧 Email: almadalaundry@gmail.com</span>
            </div>
            <div class="right">
                <a href="{{ route('login') }}">LOGIN</a>
                <a href="{{ route('register') }}">REGISTER</a>
            </div>
        </div>
    </div>

    <nav class="menu-container">
        <div class="logo">ALMADA LAUNDRY</div>
        <div class="menu">
            <a href="{{ route('home') }}">HOME</a>
            <a href="{{ route('about') }}">ABOUT US</a>
            <a href="{{ route('services') }}">SERVICES</a>
            <a href="{{ route('pricing') }}">PRICING</a>
            <a href="#">CONTACT</a>
        </div>
    </nav>


    <div class="hero">
        <h1>SERVICES</h1>
        <div class="breadcrumb">Home / Services</div>
    </div>

    <div class="section">
        <h2>SERVICES</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>

    <footer>
        <div class="footer-info">
            <div>
                <h3><i><b>ALMADA LAUNDRY</b></i></h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div>
                <h3>Get In Touch</h3>
                <p>📞 +62 812345678</p>
                <p>📧 almadalaundry@gmail.com</p>
                <p>🌐 www.almadalaundry.com</p>
                <p>📍 Jl. Sampangan No.92, Semanggi, Kec. Pasar Kliwon, Kota Surakarta, Jawa Tengah 57181</p>
            </div>
        </div>
    </footer>

</body>
</html>
