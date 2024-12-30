<header>
    <nav>
        <div class="logo">ParkingEase</div>
        <ul class="nav-links">
            <?php
            // Detect the base path dynamically
            $basePath = (basename($_SERVER['SCRIPT_FILENAME']) === 'index.php') ? './' : '../';

            // Generate dynamic links
            ?>
             <li><a href="<?= $basePath ?>index.php">Home</a></li>
            <li><a href="#" onclick="openModal()">Reservation</a></li>
            <li><a href="<?= $basePath ?>pages/about.php">About</a></li>
            <li><a href="<?= $basePath ?>pages/reviews.php">Reviews</a></li>
            <li><a href="<?= $basePath ?>pages/contact.php">Contact</a></li>
        </ul>
    </nav>
</header>
