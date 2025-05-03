<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - DelightInn</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        } */

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin: 0px 0;
            animation: fadeIn 2s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .feature {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px;
            flex: 1 1 30%;
            transition: transform 0.3s;
        }

        .feature:hover {
            transform: scale(1.05);
        }

        .owners {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .owner-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 10px;
            flex: 1 1 40%;
            transition: transform 0.3s;
            text-align: center;
        }

        .owner-card:hover {
            transform: scale(1.05);
        }

        .owner-img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-bottom: 15px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .bgcolor {
            background-image: url(https://images.pexels.com/photos/326333/pexels-photo-326333.jpeg);
            background-position: center;
            background-size: cover;
            background-repeat: none;
        }
    </style>
</head>
<body>
    
    <?php include '_dbconnect.php'; ?>
    
    <!-- navbar start -->
    <div class="container-fluid sec-1 ">
        <div class='wrapper'>
            <?php include 'navbar.php'; ?>
        </div>
    </div>
    <!-- navbar end -->

    <div class="container-fluid px-3 bgcolor text-light pt-3" style="min-height: 1000px">
        <h1>About Us</h1>
        <p class="pt-3 text-center" style="font-size: 20px"  >Welcome to our website! We are dedicated to providing you with the best experience possible. Our team is passionate about our work and committed to delivering high-quality services.</p>

        <h2>Our Features</h2>
        <div class="features text-dark">
            <div class="feature">
                <i class="fas fa-cogs fa-3x"></i>
                <h3>Service Feasibility</h3>
                <p>Reservations: Online Reservations, Walk-ins Welcome</p>
                Order Options: Online Ordering, Phone Orders, QR Code Menus.
                Payment Methods: Cashless Payments, Card Payments, Digital Wallets, Contactless Payments.
                Accessibility: Wheelchair Accessible, Elevator Available, Handicap Parking.</p>
            </div>
            <div class="feature">
                <i class="fas fa-user-friends fa-3x"></i>
                <h3>Customer Support</h3>
                <p>Connect with us through contact details in contuct us section</p>
            </div>
            <div class="feature">
                <i class="fas fa-shield-alt fa-3x"></i>
                <h3>Protection Gurantee</h3>
                <p>Your security and privacy of your personal details are our top priorities.</p>
            </div>
        </div>

        <h2>Meet the Team</h2>
        <div class="owners text-dark">
            <div class="owner-card">
                <img src="modified_pic.png" alt="Owner 1" class="owner-img">
                <h3>Muhammad Hamiz Siddiqui</h3>
                <p>Hamiz is a visionary leader with a passion for innovation.</p>
            </div>
            <div class="owner-card">
                <img src="zuhair.jpg" alt="Owner 2" class="owner-img">
                <h3>Zuhair Zeshan</h3>
                <p> brings years of experience in the industry and a commitment to excellence.</p>
            </div>
        </div>

        <h2>Why Choose Us?</h2>
        <p class="pt-2 pb-2">We believe in transparency, quality, and customer satisfaction. Our team works tirelessly to ensure that you receive the best service possible. Join us on this journey and experience the difference!</p>
    </div>

    <footer>
        <p>&copy; 2023 Your Company Name. All rights reserved.</p>
    </footer>

</body>
</html>