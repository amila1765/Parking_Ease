<footer>
    <p>&copy; 2024 ParkingEase. All Rights Reserved.</p>
    <div class="footer-links">
            <a href="/privacy-policy.php">Privacy Policy</a> | 
            <a href="/terms-of-service.php">Terms of Service</a>
        </div>
        <div class="social-media">

            <?php
            // Detect the base path dynamically
            $basePath = (basename($_SERVER['SCRIPT_FILENAME']) === 'index.php') ? './' : '../';

            // Generate dynamic links
            ?>

            <a href="https://facebook.com/parkingease" target="_blank" aria-label="Facebook">
                <img src="<?= $basePath ?>assets/images/icons/facebook-icon.png" alt="Facebook">
            </a>
            <a href="https://youtube.com/parkingease" target="_blank" aria-label="Youtube">
                <img src="<?= $basePath ?>assets/images/icons/youtube-icon.png" alt="Youtube">
            </a>
            <a href="https://linkedin.com/company/parkingease" target="_blank" aria-label="LinkedIn">
                <img src="<?= $basePath ?>assets/images/icons/linkedin-icon.png" alt="LinkedIn">
            </a>
        </div>
        <button class="back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
            Back to Top
        </button>
    </div>
</footer>

<style>
    footer {
        background: #2d3e50;
        color: white;
        text-align: center;
        padding: 1rem 0;
        font-size: 0.9rem;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .footer-links {
        margin: 1rem 0;
    }

    .footer-links a {
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
        margin: 0 0.5rem;
    }

    .footer-links a:hover {
        color: #ff6f61;
    }

    .social-media {
        margin: 1rem 0;
    }

    .social-media a {
        margin: 0 0.5rem;
        display: inline-block;
    }

    .social-media img {
        width: 24px;
        height: 24px;
    }

    .social-media a:hover img {
        opacity: 0.7;
    }

    .back-to-top {
        background: #ff6f61;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 1rem;
    }

    .back-to-top:hover {
        background: #e05548;
    }
</style>
