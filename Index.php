<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Booking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
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

        /* Home Body Section */
        .home_body {
            height: 100vh;
            background: url('./assets/images/pageBackgrounds/Home_Background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
            position: relative;
        }

        .home_body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .home_body h1, .home_body p, .home_body .reservation-btn {
            position: relative;
            z-index: 2;
        }

        .home_body h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .home_body p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .reservation-btn {
            padding: 1rem 2rem;
            font-size: 1.2rem;
            background: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .reservation-btn:hover {
            background: #e05548;
        }

        @media (max-width: 768px) {
            .home_body h1 {
                font-size: 2.5rem;
            }

            .home_body p {
                font-size: 1rem;
            }

            .reservation-btn {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
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
    <!-- Navigation Bar -->
    <?php include './includes/navbar.php'; ?>

    <!-- Main Content -->
    <main>
        <section class="home_body">
            <h1>Welcome to ParkingEase</h1>
            <p>Your hassle-free parking reservation solution.</p>
            <!-- button class="reservation-btn" onclick="openModal()">Make a Reservation</button -->
            <button id="reservation-btn" class="reservation-btn">Make a Reservation</button>
        </section>
    </main>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- Login Modal -->
    <?php include './modals/loginModal.php'; ?>

    <script>
        // Check if user is logged in based on PHP session
        const isLoggedIn = <?php echo isset($_SESSION['email']) ? '1' : '0'; ?>;

        // Add event listener for the Reservation button
        document.getElementById('reservation-btn').addEventListener('click', function () {
            if (isLoggedIn == 1) {
                // Redirect to reservation page if logged in
                window.location.href = './pages/reservation.php';
            } else {
                // Open login modal if not logged in
                openModal();
            }
        });
    </script>

    <!-- JavaScript for Responsive Menu -->
    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('show');
        });
    </script>
</body>
</html>
