<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Almada Laundry</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .top-bar {
            background-color: #003d7a;
            color: white;
            padding: 10px 0;
        }

        .top-bar .container {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar .right a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 5px 10px;
            border: 1px solid white;
            border-radius: 4px;
        }

        .menu-container {
            background-color: #f2f2f2;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 50px;
            padding-right: 50px;
        }

        .menu-container .logo {
            font-size: 20px;
        }

        .menu a {
            margin: 0 15px;
            text-decoration: none;
            color: #003d7a;
            font-weight: bold;
        }

        .about-us {
            font-family: Arial, sans-serif;
            padding: 40px 60px;
            background: #f5f5f5;
        }

        .about-header {
            text-align: center;
        }

        .about-header h2 {
            color: #003d7a;
        }

        .about-history {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .history-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .history-text {
            flex: 1;
            min-width: 300px;
        }

        .about-cards {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin: 50px 0;
            flex-wrap: wrap;
            gap: 20px;
        }

        .about-cards .card {
            flex: 1;
            min-width: 250px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .services-detail .service {
            background: white;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .services-detail h4 {
            color: #003d7a;
        }

        footer {
            background-color: #003d7a;
            color: white;
            padding: 30px 0;
        }

        footer .container {
            width: 90%;
            margin: auto;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-info div {
            max-width: 45%;
        }

        h3 {
            margin-top: 0;
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
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
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


    <section class="about-us">
        <div class="about-header">
            <h2>WELCOME TO ALMADA LAUNDRY</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>

        <div class="about-history">
            <img src="https://i.imgur.com/Ncb3p7v.jpg" alt="Laundry Interior" class="history-image">
            <div class="history-text">
                <h3>OUR HISTORY</h3>
                <p>[Your Laundry Name] was established in [Year] with the aim of providing high-quality laundry services to the community. It started as a small business with a simple goal: to offer efficient and affordable laundry solutions.</p>
                <p>In the early days, [Your Laundry Name] operated with just a few machines and a dedicated team committed to customer satisfaction. Over time, the business grew as more customers recognized the quality and reliability of our services.</p>
                <p>Through continuous improvement and a commitment to excellence, [Your Laundry Name] has expanded its services to meet the evolving needs of our customers. Today, we continue to prioritize customer convenience and quality, ensuring that every garment is cleaned with care and professionalism.</p>
            </div>
        </div>

        <div class="about-cards">
            <div class="card">
                <h4>OUR VISION</h4>
                <p>"To be the leading laundry service that provides maximum cleanliness, customer comfort, and professional service with modern and eco-friendly technology."</p>
            </div>
            <div class="card">
                <h4>OUR MISSION</h4>
                <p>To deliver high-quality, fast, and affordable laundry services with advanced technology and customer satisfaction at the core.</p>
            </div>
            <div class="card">
                <h4>OUR STRENGTHS</h4>
                <p>We offer premium cleaning, eco-friendly practices, fast service, competitive pricing, and convenient pick-up and delivery options.</p>
            </div>
        </div>

        <div class="services-detail">
            <div class="service">
                <h4>DRY CLEANING</h4>
                <p>Dry cleaning is a cleaning process that uses a chemical solvent instead of water to remove stains and dirt from fabrics. This method is ideal for delicate materials like silk, wool, and certain synthetics. The most common solvent used is perchloroethylene (perc), which cleans clothes effectively without damaging their texture or color.</p>
            </div>
            <div class="service">
                <h4>SPECIAL ITEMS</h4>
                <p>Special items in laundry refer to clothing or fabrics that require extra care during cleaning. These may include wedding dresses, suits, curtains, blankets, and designer clothes. They often need specialized methods like hand washing, spot cleaning, or dry cleaning to prolong their lifespan.</p>
            </div>
            <div class="service">
                <h4>LAUNDRY PRESS</h4>
                <p>A laundry press is a machine used to remove wrinkles and create a crisp finish on garments. It applies heat and pressure, making clothes look professionally ironed. Pressing is common for formal wear like suits, shirts, and trousers to achieve a polished look.</p>
            </div>
            <div class="service">
                <h4>LEATHER ITEMS</h4>
                <p>Leather items include jackets, bags, shoes, and furniture upholstery that require specialized cleaning. Leather can't be washed with water or regular detergents as it may shrink or crack. Professional cleaning involves gentle solutions, conditioning, and polishing to maintain the leather’s natural oils and durability.</p>
            </div>
        </div>
    </section>

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
