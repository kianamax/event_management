<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightlane Event Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #8A2BE2;
            --secondary-color: #FF00FF;
            --text-color: #FFFFFF;
            --bg-color: #000000;
            --dark-bg-color: #1E1E1E;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            height: 100%; /* Ensure the body takes full viewport height */
            overflow: hidden; /* Disable scrolling on body to handle it via script */
        }

        .container {
            width: 100%;
            padding: 0 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
             position: fixed;
             top: 0;
             width: 100%;
             z-index: 10;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .logo span {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color);
        }

        nav ul {
            display: flex;
            list-style-type: none;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 18px;
        }

        nav ul li a:hover {
            color: var(--primary-color);
        }
        section {
            min-height: 100vh; /* Each section must fill the viewport */
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-sizing: border-box;
}

        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/api/placeholder/1400/800');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--text-color);
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }
        .services, #contact {
        padding: 70px 0; /* Adjust padding as necessary */
        }

         .about-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-text {
            flex: 1;
        }

        .about-image {
            flex: 1;
        }

        .about-image img {
            width: 100%;
            border-radius: 10px;
        }



        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            padding: 70px 0;
        }

        .service-item {
            flex-basis: calc(50% - 15px);
            background-color: var(--dark-bg-color);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(138, 43, 226, 0.2);
        }

        .service-item h3 {
            margin-bottom: 15px;
            color: var(--primary-color);
            font-size: 24px;
        }

        .service-item p {
            font-size: 16px;
        }

        #contact {
            background-color: var(--dark-bg-color);
            padding: 70px 0;
            text-align: center;
        }

        .contact-title {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .contact-subtitle {
            font-size: 20px;
            color: #999;
            margin-bottom: 50px;
        }

        .contact-methods {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .contact-method {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            width: calc(25% - 22.5px);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .contact-method:hover {
            transform: translateY(-10px);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .contact-method i {
            font-size: 32px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .contact-method p {
            font-size: 18px;
        }

        @media (max-width: 1024px) {
            .service-item, .contact-method {
                flex-basis: calc(50% - 15px);
            }
        }

        @media (max-width: 768px) {
            .service-item, .contact-method {
                flex-basis: 100%;
            }
            .hero h1 {
                font-size: 36px;
            }
            .hero p {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    
                    <span>BRIGHTLANE</span>
                </div>
                <nav>
                    <ul>
                        <li><a href="#home">HOME</a></li>
                        <li><a href="#about">ABOUT</a></li>
                        <li><a href="#services">SERVICES</a></li>
                        <li><a href="#contact">CONTACT</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section id="home" class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Revolutionize Your Event Planning</h1>
                    <p>Streamline your events with Brightlane's all-in-one management system</p>
                    <a href="login.php" class="btn">Get Started Today</a>
                </div>
            </div>
        </section>

        <section id="about">
            <div class="container">
                <h2>About Brightlane</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>Brightlane is a cutting-edge event management system designed to streamline the entire event planning process. Our platform is built on years of industry experience and powered by the latest technology to provide a seamless, intuitive experience for event organizers and attendees alike.</p>
                        <p>From small local gatherings to large-scale international conferences, Brightlane offers the tools and support you need to create unforgettable events. Our mission is to empower event professionals with innovative solutions that save time, reduce stress, and enhance the overall event experience.</p>
                    </div>
                    <div class="about-image">
                        <img src="event2.jpg" alt="Brightlane team">
                    </div>
                </div>
            </div>
        </section>

        <section id="services">
            <div class="container">
                <div class="services">
                    <div class="service-item">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Comprehensive Event Planning</h3>
                        <p>Our all-in-one platform streamlines your event planning process. From venue selection and budget management to speaker coordination and timeline creation, Brightlane ensures no detail is overlooked.</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-users"></i>
                        <h3>Advanced Attendee Management</h3>
                        <p>Simplify registration, ticketing, and communication. Our powerful system handles attendee data securely, automates email campaigns, and provides real-time attendance tracking for seamless event experiences.</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-video"></i>
                        <h3>Virtual and Hybrid Event Solutions</h3>
                        <p>Expand your reach with our cutting-edge virtual event tools. Integrate live streaming, interactive Q&A sessions, networking lounges, and virtual exhibition halls to engage attendees globally.</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-chart-bar"></i>
                        <h3>Real-time Analytics and Reporting</h3>
                        <p>Make data-driven decisions with our comprehensive analytics. Track attendee engagement, measure ROI, and generate customizable reports to continually improve your events and demonstrate value to stakeholders.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact">
            <div class="container">
                <h2 class="contact-title">Get in Touch</h2>
                <p class="contact-subtitle">Let's elevate your next event together</p>
                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="fas fa-envelope"></i>
                        <p>info@brightlane.com</p>
                    </div>
                    <div class="contact-method">
                        <i class="fas fa-phone"></i>
                        <p>+1 (800) 123-4567</p>
                    </div>
                    <div class="contact-method">
                        <i class="fab fa-twitter"></i>
                        <p>@BrightlaneEvents</p>
                    </div>
                    <div class="contact-method">
                        <i class="fab fa-linkedin"></i>
                        <p>Brightlane Events</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('section');
    let currentSectionIndex = 0;

    window.addEventListener('wheel', (e) => {
        if (e.deltaY < 0 && currentSectionIndex > 0) {
            // Scrolling up
            currentSectionIndex--;
        } else if (e.deltaY > 0 && currentSectionIndex < sections.length - 1) {
            // Scrolling down
            currentSectionIndex++;
        }
        window.scrollTo({
            top: sections[currentSectionIndex].offsetTop,
            behavior: 'smooth'
        });
    });
});

    </script>
</body>
</html>