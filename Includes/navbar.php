<header>
    <nav>
        <div class="logo">ParkingEase</div>
        <ul class="nav-links">
        <?php
            // Detect the base path dynamically
            $basePath = (basename($_SERVER['SCRIPT_FILENAME']) === 'index.php') ? './' : '../';

            // Generate dynamic links
            ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="#" onclick="openModal()">Reservation</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>
