<?php
// Start the session before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - ParkingEase</title>
    <link rel="stylesheet" href="styles.css">
    <style>

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

        .contact-section {
            height: 100vh;
            background: url('../assets/images/pageBackgrounds/Contact_Background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
            position: relative;
        }

        .contact-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .contact-section h1, .contact-section form {
            position: relative;
            z-index: 2;
        }

        .contact-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s;
        }

        .contact-section form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
            max-width: 400px;
        }

        .contact-section form input, .contact-section form textarea {
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .contact-section form button {
            padding: 0.75rem;
            background: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .contact-section form button:hover {
            background: #e05548;
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
    <?php include '../includes/navbar.php'; ?>

    <section class="contact-section">
        <h1>Contact Us</h1>
        <form action="#" method="post">
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
            <input type="tel" placeholder="Your Contact Number" required>
            <textarea placeholder="Your Message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

    <?php include '../includes/footer.php'; ?>

    <!-- Login Modal -->
    <?php include '../modals/loginModal.php'; ?>
    <script>
        document.getElementById('contact-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('../api/contact_API.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    alert(result.message);
                    this.reset();
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong!');
            }
        });
    </script>
</body>
</html>
