<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almada Laundry</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .top-bar {
            background-color: #002366;
            color: white;
            padding: 10px 0;
            font-size: 14px;
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .top-bar .right a {
            margin-left: 10px;
            background-color: white;
            color: #002366;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .menu-container {
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #ccc;
        }

        .logo {
            font-size: 24px;
            color: #002366;
        }

        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .hero {
            background-color: #d8e8f8;
            padding: 40px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .hero .text {
            max-width: 50%;
        }

        .hero h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .hero button {
            background-color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .hero img {
            width: 300px;
            border-radius: 50%;
        }

        .why-choose {
            text-align: center;
            padding: 40px 20px;
        }

        .why-choose h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .icons {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .icon-box {
            text-align: center;
            max-width: 150px;
        }

        .icon-box img {
            width: 50px;
            height: 50px;
        }

        .services-section {
            background-color: #cfe5f4;
            text-align: center;
            padding: 40px 20px;
        }

        .services-section h2 {
            font-size: 24px;
        }

        .service-image {
            width: 300px;
            margin: 20px auto;
        }

        .stats-bar {
            background-color: #003366;
            color: white;
            display: flex;
            justify-content: space-around;
            padding: 30px 20px;
        }

        .stats-item {
            text-align: center;
        }

        .stats-item img {
            width: 40px;
        }

        .testimonials {
            padding: 40px 20px;
            text-align: center;
        }

        .testimonial-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .testimonial-box {
            max-width: 200px;
            text-align: center;
        }

        .testimonial-box img {
            width: 100px;
            border-radius: 50%;
        }

        footer {
            background-color: #002366;
            color: white;
            padding: 20px;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-info div {
            margin: 10px;
            max-width: 300px;
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
        <div class="text">
            <h1>WELCOME!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <button>Cek Laundry Kamu</button>
        </div>
        <img src="/mnt/data/image.png" alt="Laundry Image">
    </div>

    <div class="why-choose">
        <h2>WHY CHOOSE US ?</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <div class="icons">
            <div class="icon-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/discount.png" alt="Discount">
                <p><b>LOREMIPSUM</b></p>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="icon-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/washing-machine.png" alt="Machine">
                <p><b>LOREMIPSUM</b></p>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="icon-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/laundry.png" alt="Laundry">
                <p><b>LOREMIPSUM</b></p>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="icon-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/diamond.png" alt="Diamond">
                <p><b>LOREMIPSUM</b></p>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
    </div>

    <div class="services-section">
        <h2>OUR SERVICE</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <img class="service-image" src="/mnt/data/image.png" alt="Our Service">
    </div>

    <div class="stats-bar">
        <div class="stats-item">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/laundry-basket.png"/>
            <p>250<br>LOREMIPSUM</p>
        </div>
        <div class="stats-item">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/coffee.png"/>
            <p>250<br>LOREMIPSUM</p>
        </div>
        <div class="stats-item">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/facebook-like.png"/>
            <p>250<br>LOREMIPSUM</p>
        </div>
        <div class="stats-item">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/conference-call.png"/>
            <p>250<br>LOREMIPSUM</p>
        </div>
    </div>

    <div class="testimonials">
        <h2>TESTIMONIALS</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <div class="testimonial-grid">
            <div class="testimonial-box">
                <img src="https://via.placeholder.com/100" alt="Customer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><b>NAME</b></p>
            </div>
            <div class="testimonial-box">
                <img src="https://via.placeholder.com/100" alt="Customer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><b>NAME</b></p>
            </div>
            <div class="testimonial-box">
                <img src="https://via.placeholder.com/100" alt="Customer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><b>NAME</b></p>
            </div>
            <div class="testimonial-box">
                <img src="https://via.placeholder.com/100" alt="Customer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><b>NAME</b></p>
            </div>
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
