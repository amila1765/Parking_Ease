<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - ParkingEase</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Profile Page Styles */

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

        body {
            font-family: Arial, sans-serif;
            background: url('../assets/images/pageBackgrounds/Singup_Background.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }
        .profile-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
        }
        .profile-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info p {
            margin: 10px 0;
            font-size: 1.1rem;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .update-btn, .delete-btn {
            background: #ff6f61;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .update-btn:hover, .delete-btn:hover {
            background: #e05548;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            overflow: hidden; /* Prevent background scroll */
        }

        .modal-content {
            background-color: white;
            margin: 10% auto; /* Adjusted margin to center it better */
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            max-height: 80vh; /* Set maximum height */
            overflow-y: auto; /* Make content scrollable if necessary */
        }

        /* To prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #e05548;
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
    <?php include '../includes/navbar.php'; ?>

    <div class="container">
        <div class="profile-container">
            <h2>Your Profile</h2>

            <div class="profile-info" id="user-info">
                <!-- User Info will be populated here via JS -->
            </div>

            <div class="vehicle-info" id="vehicle-info">
                <!-- Vehicle Info will be populated here via JS -->
            </div>

            <div class="button-container">
            <button class="update-btn" onclick="openUpdateModal()">Update Profile</button>
                <button class="delete-btn" onclick="openDeleteModal()">Delete Profile</button>

            </div>
        </div>
    </div>

    <!-- Include the update profile modal -->
    <?php include '../modals/update_profile_modal.php'; ?>

    <script>
    // Function to fetch user profile data from the API
    async function getUserProfile() {
        const response = await fetch('../API/get_user_profile.php');
        const result = await response.json();
        console.log(result); // Log the response for debugging

        if (result.status === 'success') {
            // Populate user info
            const user = result.user;
            const userInfoDiv = document.getElementById('user-info');
            userInfoDiv.innerHTML = `
                <p><strong>First Name:</strong> ${user.first_name}</p>
                <p><strong>Last Name:</strong> ${user.last_name}</p>
                <p><strong>Email:</strong> ${user.email}</p>
                <p><strong>Contact Number:</strong> ${user.contact_number}</p>
                <p><strong>Birthday:</strong> ${user.birthday}</p>
                <p><strong>Gender:</strong> ${user.gender}</p>
            `;

            // Populate vehicle info
            const vehicleInfoDiv = document.getElementById('vehicle-info');
            if (result.vehicles.length > 0) {
                let vehicleHTML = '<h3>Your Vehicles:</h3>';
                result.vehicles.forEach(vehicle => {
                    vehicleHTML += `
                        <p><strong>Vehicle Type:</strong> ${vehicle.vehicle_type}</p>
                        <p><strong>Vehicle Number:</strong> ${vehicle.vehicle_number}</p>
                        <hr>
                    `;
                });
                vehicleInfoDiv.innerHTML = vehicleHTML;
            } else {
                vehicleInfoDiv.innerHTML = '<p>No vehicles found.</p>';
            }
        } else {
            alert(result.message);
        }
    }

    // Function to open the modal and pre-fill the form with current user and vehicle data
    async function openUpdateModal() {
        const response = await fetch('../API/get_user_profile.php');
        const result = await response.json();
        if (result.status === 'success') {
            const user = result.user;
            const vehicle = result.vehicles.length > 0 ? result.vehicles[0] : {}; // Get the first vehicle (if any)

            // Pre-fill the form with user data
            document.getElementById('update-first-name').value = user.first_name;
            document.getElementById('update-last-name').value = user.last_name;
            document.getElementById('update-birthday').value = user.birthday;
            document.getElementById('update-gender').value = user.gender;
            document.getElementById('update-contact').value = user.contact_number;
            document.getElementById('update-email').value = user.email;

            // Pre-fill the vehicle fields if available
            document.getElementById('update-vehicle-type').value = vehicle.vehicle_type || '';
            document.getElementById('update-vehicle-number').value = vehicle.vehicle_number || '';

            // Display the modal
            document.getElementById('updateProfileModal').style.display = 'block';
            document.body.classList.add('modal-open');
        } else {
            alert(result.message);
        }
    }

    // Function to close the modal
    function closeUpdateModal() {
        document.getElementById('updateProfileModal').style.display = 'none';

        // Remove modal-open class to allow background scrolling
        document.body.classList.remove('modal-open');
    }

    // Function to handle form submission and update the profile
    document.getElementById('update-profile-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const payload = {
            first_name: formData.get('first_name'),
            last_name: formData.get('last_name'),
            birthday: formData.get('birthday'),
            gender: formData.get('gender'),
            contact_number: formData.get('contact_number'),
            email: formData.get('email')
        };

        const response = await fetch('../API/update_user_profile.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        alert(result.message);
        if (result.status === 'success') {
            closeUpdateModal(); // Close the modal if the update is successful
            location.reload();  // Reload the page to reflect updated profile data
        }
    });


    // Delete Profile
    function deleteProfile() {
        if (confirm("Are you sure you want to delete your profile? This action is irreversible.")) {
            window.location.href = 'delete_profile.php';
        }
    }

    function openDeleteModal() {
        document.getElementById('deleteProfileModal').style.display = 'block';
        document.body.classList.add('modal-open');
    }

    function closeDeleteModal() {
        document.getElementById('deleteProfileModal').style.display = 'none';
        document.body.classList.remove('modal-open');
    }

    document.getElementById('delete-profile-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const password = document.getElementById('delete-password').value;

        const response = await fetch('../API/delete_user_profile.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ password: password })
        });

        const result = await response.json();
        alert(result.message);

        if (result.status === 'success') {
            window.location.href = '/Parking_Ease/index.php';
        } else {
            document.getElementById('delete-password').value = '';
        }
    });


    // Call the function to fetch user data on page load
    getUserProfile();
    </script>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <script src="../assets/scripts/profile.js"></script>

</body>
</html>
