<?php
// Start the session before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - ParkingEase</title>
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
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: url('../assets/images/pageBackgrounds/Singup_Background.jpg') no-repeat center center fixed;
            background-size: cover;

            /* Enable scrolling if content exceeds viewport */
            min-height: 100vh;
            overflow-y: auto;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items to the top */
            min-height: 100vh; /* Allow height to adjust dynamically */
            padding: 20px; /* Add padding to avoid tight edges */
        }

        .signup-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            margin-bottom: 20px; /* Add margin to prevent footer overlap */
        }

        .signup-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 95%;
            padding: 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-vehicle-btn {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-vehicle-btn:hover {
            background: #e05548;
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

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #ff6f61;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .vehicle-field {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
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
    <form class="signup-form" id="signup-form">
            <h2>Create Your Account</h2>

        <!-- Personal Information -->
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" placeholder="Enter First Name" required>
            </div>

            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" placeholder="Enter Last Name" required>
            </div>

            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" id="birthday" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact_number" placeholder="Enter Contact Number" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
            </div>

            <!-- Vehicle Details -->
            <div class="form-group">
                <label>Vehicle Details</label>
                <div id="vehicle-container">
                    <div class="vehicle-field">
                        <select name="vehicle_type[]" required>
                            <option value="">Select Vehicle Type</option>
                            <option value="Car">Car</option>
                            <option value="SUV">SUV</option>
                            <option value="Van">Van</option>
                            <option value="Two Wheeler">Two Wheeler</option>
                            <option value="Three Wheeler">Three Wheeler</option>
                        </select>
                        <input type="text" name="vehicle_number[]" placeholder="Vehicle Number" required>
                    </div>
                </div>
                <button type="button" class="add-vehicle-btn" onclick="addVehicleField()">Add Another Vehicle</button>
            </div>

            <!--Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">Sign Up</button>

            <p class="login-link">Already have an account? <a href="#" onclick="window.history.back()">Login</a></p>
        </form>
    </div>

    <script>
        function addVehicleField() {
            const container = document.getElementById('vehicle-container');
            const vehicleField = document.createElement('div');
            vehicleField.classList.add('vehicle-field');

            const vehicleType = document.createElement('select');
            vehicleType.innerHTML = `
                <option value="">Select Vehicle Type</option>
                <option value="Car">Car</option>
                <option value="SUV">SUV</option>
                <option value="Van">Van</option>
                <option value="Two Wheeler">Two Wheeler</option>
                <option value="Three Wheeler">Three Wheeler</option>`;
            
            const vehicleNumber = document.createElement('input');
            vehicleNumber.type = 'text';
            vehicleNumber.name = 'vehicle_number[]';//Esure the name matches the array
            vehicleNumber.placeholder = 'Vehicle Number';
            vehicleNumber.required = true;

            vehicleField.appendChild(vehicleType);
            vehicleField.appendChild(vehicleNumber);
            container.appendChild(vehicleField);
        }

        // Form submission logic for API call
        document.getElementById('signup-form').addEventListener('submit',async function(e) {e.preventDefault();
        
            const formData = new FormData(e.target);
            const vehicle = [];
            const vehicleTypes = formData.getAll('vehicle_type[]');
            const vehicleNumbers = formData.getAll('vehicle_number[]');

            for (let i = 0; i <vehicleTypes.length; i++){
                vehicle.push({vehicle_type: vehicleTypes[i], vehicle_number:vehicleNumbers[i]});
            }

            const payload = {
                first_name:formData.get('first_name'),
                last_name:formData.get('last_name'),
                birthday: formData.get('birthday'),
                gender: formData.get('gender'),
                contact_number: formData.get('contact_number'),
                email: formData.get('email'),
                password: formData.get('password'),
                vehicles: vehicles
        };

        const response = await fetch('../api/register_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        alert(result.message);
        if (result.status === 'success') {
            window.location.href = '../index.php'; // Redirect to login page
            }
        });
    </script>

     <!-- Footer -->
     <?php include '../includes/footer.php'; ?>
</body>
</html>
