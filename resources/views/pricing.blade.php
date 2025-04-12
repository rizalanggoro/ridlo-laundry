<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pricing - Almada Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            background-color: #003366;
            color: #fff;
            padding: 10px 0;
            font-size: 14px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .menu-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f5f5f5;
            padding: 15px 5%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            font-weight: bold;
            font-size: 20px;
            color: #003366;
        }

        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #003366;
            font-weight: bold;
        }

        .btn-login, .btn-register {
            margin-left: 10px;
            background-color: #fff;
            color: #003366;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #fff;
            border-radius: 4px;
        }

        .hero {
            background-image: url('/path/to/laundry-banner.jpg'); /* Ganti sesuai path gambar */
            background-size: cover;
            background-position: center;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px 5%;
            color: #003366;
        }

        .hero h1 {
            font-size: 36px;
            margin: 0;
        }

        .hero p {
            margin: 5px 0;
        }

        .section {
            padding: 40px 5%;
            text-align: center;
        }

        .section h2 {
            color: #003366;
            margin-bottom: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            width: 200px;
            padding: 20px;
        }

        .card h3 {
            font-size: 18px;
            color: #003366;
        }

        .card p.price {
            color: #007bff;
            font-size: 20px;
            font-weight: bold;
        }

        .card ul {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 10px;
        }

        .card ul li {
            margin-bottom: 5px;
        }

        .card button {
            background-color: #003366;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
        }

        .pricing-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .pricing-category {
            width: 250px;
            text-align: left;
        }

        .pricing-category h4 {
            color: #003366;
            border-bottom: 2px solid #cce0f5;
            padding-bottom: 5px;
        }

        .pricing-category ul {
            background-color: #e6f0ff;
            padding: 15px;
            border-radius: 5px;
            list-style: disc;
            margin: 0;
        }

        footer {
            background-color: #003366;
            color: white;
            padding: 30px 5%;
            margin-top: 60px;
        }

        .footer-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-info div {
            margin-bottom: 20px;
            width: 250px;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="container">
            <div class="left">
                <span>📞 Phone: +62 812345678</span>
                <span style="margin-left: 20px;">📧 Email: almadalaundry@gmail.com</span>
            </div>
            <div class="right">
                <a href="{{ route('login') }}" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
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
        <h1>PRICING</h1>
        <p>Home / Pricing</p>
    </div>

    <section class="section">
        <h2>OUR PRICING TABLE</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

        <div class="card-container">
            <div class="card">
                <h3>Regular Bag</h3>
                <p class="price">Rp15.000,-</p>
                <ul>
                    <li>500g</li>
                    <li>Home Delivery</li>
                    <li>Ironing</li>
                    <li>Perfume</li>
                    <li>1 Day Finish</li>
                </ul>
                <button>ORDER NOW</button>
            </div>
            <div class="card">
                <h3>Medium Bag</h3>
                <p class="price">Rp18.000,-</p>
                <ul>
                    <li>1000g</li>
                    <li>Home Delivery</li>
                    <li>Ironing</li>
                    <li>Perfume</li>
                    <li>1 Day Finish</li>
                </ul>
                <button>ORDER NOW</button>
            </div>
            <div class="card">
                <h3>Large Bag</h3>
                <p class="price">Rp20.000,-</p>
                <ul>
                    <li>1200g</li>
                    <li>Home Delivery</li>
                    <li>Ironing</li>
                    <li>Perfume</li>
                    <li>1 Day Finish</li>
                </ul>
                <button>ORDER NOW</button>
            </div>
            <div class="card">
                <h3>XLarge Bag</h3>
                <p class="price">Rp25.000,-</p>
                <ul>
                    <li>2000g</li>
                    <li>Home Delivery</li>
                    <li>Ironing</li>
                    <li>Perfume</li>
                    <li>1 Day Finish</li>
                </ul>
                <button>ORDER NOW</button>
            </div>
        </div>
    </section>

    <section class="section">
        <h2>MORE DETAIL PRICING</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

        <div class="pricing-grid">
            <div class="pricing-category">
                <h4>Dry Cleaning</h4>
                <ul>
                    <li>All Shirts</li>
                    <li>Pants, Jeans, Skirt</li>
                    <li>Tie, Scarf</li>
                    <li>Coat, Heavy Jacket, Dress</li>
                </ul>
            </div>
            <div class="pricing-category">
                <h4>Laundry Press</h4>
                <ul>
                    <li>Sheets</li>
                    <li>Pillowcases</li>
                    <li>Duvet Covers</li>
                    <li>Bed Covers</li>
                    <li>Gorden</li>
                </ul>
            </div>
            <div class="pricing-category">
                <h4>Special Items</h4>
                <ul>
                    <li>Fancy Dresses</li>
                    <li>Comforters</li>
                    <li>Handkerchief</li>
                    <li>Tuxedo Shirt</li>
                    <li>Polo (laundered short sleeve)</li>
                </ul>
            </div>
            <div class="pricing-category">
                <h4>Special Items</h4>
                <ul>
                    <li>Fancy Dresses</li>
                    <li>Comforters</li>
                    <li>Handkerchief</li>
                    <li>Tuxedo Shirt</li>
                    <li>Polo (laundered short sleeve)</li>
                </ul>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-info">
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
    </footer>

</body>
</html>
