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
            <li>
                <?php if (isset($_SESSION['email'])): ?>
                    <a href="<?= $basePath ?>pages/reservation.php">Reservation</a>
                <?php else: ?>
                    <a href="#" onclick="openModal()">Reservation</a>
                <?php endif; ?>
            </li>

            <li><a href="<?= $basePath ?>pages/about.php">About</a></li>
            <li><a href="<?= $basePath ?>pages/reviews.php">Reviews</a></li>
            <li><a href="<?= $basePath ?>pages/contact.php">Contact</a></li>
            
            <!-- Display username if logged in -->
            <?php if (isset($_SESSION['email'])): ?>
                <li class="dropdown">
                    <a href="#" id="userDropdown" onclick="toggleDropdown()"><?php echo htmlspecialchars($_SESSION['email']); ?></a>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="/Parking_Ease/pages/profile.php">View Profile</a>
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

    // Handle logout
    function logout() {
        fetch(window.location.origin + '/Parking_Ease/api/logout_API.php')// Assuming logout_API.php destroys the session
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Redirect to the home page after successful logout
                    window.location.href = '/Parking_Ease/index.php';
                } else {
                    alert('Logout failed!');
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                alert('Something went wrong during logout.');
            });
    }
</script>

<style>
    /* Dropdown Styles */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown a {
        cursor: pointer;
        padding: 10px;
        color: white;
        text-decoration: none;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: black;
        min-width: 150px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        border-radius: 5px;
    }

    .dropdown-menu a {
        padding: 12px 16px;
        display: block;
        color: #333;
        text-decoration: none;
        transition: 0.3s;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }
</style>