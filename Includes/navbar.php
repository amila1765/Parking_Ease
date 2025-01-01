<?php ob_start(); ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
             <?php if (isset($_SESSION['email'])): ?>
                    <a href="<?= $basePath ?>pages/reservation.php">Reservation</a>
                <?php else: ?>
            <li><a href="#" onclick="openModal()">Reservation</a></li>
            <li><a href="<?= $basePath ?>pages/about.php">About</a></li>
            <li><a href="<?= $basePath ?>pages/reviews.php">Reviews</a></li>
            <li><a href="<?= $basePath ?>pages/contact.php">Contact</a></li>

             <!-- Display username if logged in -->
             <?php if (isset($_SESSION['email'])): ?>
                <li class="dropdown">
                    <a href="#" id="userDropdown" onclick="toggleDropdown()"><?php echo htmlspecialchars($_SESSION['email']); ?></a>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="../pages/profile.php">View Profile</a>
                        <a href="#" id="logout-btn" onclick="logout()">Logout</a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
    // Toggle dropdown visibility on user name click
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

     // Close dropdown if clicked outside
     window.onclick = function(event) {
        // Close dropdown only if clicked outside of any dropdown menu
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach(menu => {
            const dropdownButton = menu.previousElementSibling;
            
            if (!dropdownButton.contains(event.target) && !menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    }

    

</script>