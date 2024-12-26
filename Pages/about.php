<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - ParkingEase</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Navigation Bar */
        header {
            background: #2d3e50;
            color: white;
            padding: 1rem 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1rem;
        }

        .nav-links li a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .nav-links li a:hover {
            color: #ff6f61;
        }

        /* Responsive Navigation */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                display: none;
                position: absolute;
                top: 60px;
                right: 1rem;
                background: #2d3e50;
                padding: 1rem;
                border-radius: 5px;
                width: 200px;
            }

            .nav-links.show {
                display: flex;
            }

            .menu-toggle {
                display: block;
                cursor: pointer;
                color: white;
                font-size: 1.5rem;
            }
        }

        .menu-toggle {
            display: none;
        }

        .about-section {
            height: 100vh;
            background: url('./Assets/About_Background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
            position: relative;
        }

        .about-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .about-section h1, .about-section p {
            position: relative;
            z-index: 2;
        }

        .about-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s;
        }

        .about-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1.5s;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            background: #2d3e50;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="about-section">
        <h1>About ParkingEase</h1>
        <p>
            ParkingEase is your go-to solution for hassle-free parking reservations. 
            We aim to save your time and effort with seamless parking management.
        </p>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Login Modal -->
    <?php include 'login_modal.php'; ?>
</body>
</html>
