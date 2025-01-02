<?php
// Start the session before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - ParkingEase</title>
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

        /* Reviews Section */
        .reviews-section {
            background: url('../assets/images/pageBackgrounds/Reviews_Background.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            padding: 2rem 1rem;
            position: relative;
        }

        .reviews-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .reviews-section h1, .reviews-section .review-form, .reviews-section .review-tiles {
            position: relative;
            z-index: 2;
        }

        .reviews-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1.5s;
        }

        /* Review Submission Form */
        .review-form {
            margin-bottom: 3rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            color: #333;
            text-align: left;
        }

        .review-form h2 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .review-form input, .review-form textarea, .review-form button {
            width: 95%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .review-form button {
            padding: 10px 20px;
            display: inline-block;
            background: #ff6f61;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .review-form button:hover {
            background: #e05548;
        }

        /* Star Rating */
        .star-rating {
            display: flex;
            gap: 0.5rem;
        }

        .star {
            font-size: 3rem;
            color: #ccc;
            cursor: pointer;
        }

        .star.selected {
            color: #ff6f61;
        }

        /* Review Tiles */
        .review-tiles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            width: 100%;
            max-width: 1200px;
        }

        .review-tile {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 5px;
            color: white;
            text-align: left;
            animation: fadeInUp 1.5s;
        }

        .review-tile .stars {
            margin-bottom: 0.5rem;
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
    <?php include '../includes/navbar.php'; ?>


    <section class="reviews-section">
        <h1>Customer Reviews</h1>

        <!-- Review Submission Form -->
        <div class="review-form">
            <h2>Submit Your Review</h2>
            <form id="reviews-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="review" rows="5" placeholder="Your Experience..." required></textarea>
                
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
                <button type="submit">Submit Review</button>
            </form>
        </div>

      <!-- Display Reviews -->
      <div class="review-tiles" id="review-tiles">
            <!-- Reviews will be injected here via JavaScript -->
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <!-- Login Modal -->
    <?php include '../modals/loginModal.php'; ?>

    <script>

        // Fetch reviews from the API and display them
        async function fetchReviews() {
            try {
                const response = await fetch('../API/displayReviews_API.php'); // API endpoint for reviews
                const data = await response.json(); // Parse the JSON response

                const reviewTiles = document.getElementById('review-tiles');
                reviewTiles.innerHTML = ''; // Clear previous reviews

                if (data.length > 0) {
                    // Iterate through each review and display it
                    data.forEach(review => {
                        const reviewTile = document.createElement('div');
                        reviewTile.classList.add('review-tile');
                        reviewTile.innerHTML = `
                            <div class="stars">
                                ${generateStars(review.rating)}
                            </div>
                            <p>"${review.review_text}"</p>
                            <small>- ${review.Name}</small>
                        `;
                        reviewTiles.appendChild(reviewTile);
                    });
                } else {
                    // If no reviews are found, show a message
                    reviewTiles.innerHTML = '<p>No reviews yet.</p>';
                }
            } catch (error) {
                console.error('Error fetching reviews:', error);
            }
        }

        // Helper function to generate star ratings
        function generateStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= rating ? '&#9733;' : '&#9734;';
            }
            return starsHtml;
        }

        // Call fetchReviews when the page loads
        window.onload = fetchReviews;

        // Handle form submission for new reviews
        document.getElementById('reviews-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Log form data for debugging
        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        // Log form data for debugging
        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        try {
            const response = await fetch('../API/reviews_API.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                this.reset(); // Reset the form after successful submission
                location.reload(); // Reload the page after successful submission
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while submitting the review. Please check the console for more details.');
        }
    });
    </script>   

    <script>
        // Star Rating Selection
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                stars.forEach(s => s.classList.remove('selected'));
                star.classList.add('selected');

                // Highlight previous stars
                let starValue = parseInt(star.getAttribute('data-value'));
                ratingInput.value = starValue;
                for (let i = 0; i < starValue; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });
    </script>
</body>
</html>
