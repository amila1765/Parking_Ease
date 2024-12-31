<?php
// Start the session before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            padding: 0;
            box-sizing: border-box;
            background-image: url('../assets/images/pageBackgrounds/Reservation_Background.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh; /* Ensures the page takes full height */
            display: flex;
            flex-direction: column; /* To allow footer to stay at the bottom */
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

        /* Parking Location Tiles */
        .parking-tiles {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 2rem;
        }

        .tile {
            width: 200px;
            height: 200px;
            background-color: #ff6f61;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .tile:hover {
            transform: scale(1.1);
        }

        /* Reservation Popup */
        .modal {
            display: none; /* Hidden initially */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Dimming background */
            justify-content: center; /* Horizontal centering */
            align-items: center; /* Vertical centering */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333;
        }

        .modal-content input,
        .modal-content select,
        .modal-content button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content button {
            background: #ff6f61;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .modal-content button:hover {
            background: #e05548;
        }

        /* Success Popup */
        #summaryPopup {
            display: none;
        }

        #summaryPopup .modal-content {
            background-color: #4CAF50;
            color: white;
        }

        /* Footer */
        footer {
            background: #2d3e50;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto; /* Ensures the footer is at the bottom */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include '../includes/navbar.php'; ?>

    <!-- Main Content -->
    <main>
        <section class="home_body">
            <!-- Parking Location Tiles displayed immediately -->
            <div class="parking-tiles" id="parkingTiles">
                <div class="tile" onclick="openReservationPopup('Location 1')">
                    <p>Location 1</p>
                </div>
                <div class="tile" onclick="openReservationPopup('Location 2')">
                    <p>Location 2</p>
                </div>
                <div class="tile" onclick="openReservationPopup('Location 3')">
                    <p>Location 3</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- Reservation Popup -->
    <div id="reservationPopup" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeReservationPopup()">×</span>
            <h2>Book Parking Lot at <span id="locationName"></span></h2>
            <form id="reservationForm" method="POST" action="">
                <label for="parkingLot">Select Parking Lot:</label>
                <select id="parkingLot" name="parkingLot">
                    <option value="1">Lot 1</option>
                    <option value="2">Lot 2</option>
                    <option value="3">Lot 3</option>
                </select>

                <label for="timeRange">Select Time Range:</label>
                <input type="time" id="startTime" name="startTime">
                <input type="time" id="endTime" name="endTime">

                <p>Total Charge: $<span id="totalCharge">0</span></p>

                <input type="hidden" id="hiddenLocation" name="location">
                <input type="hidden" id="hiddenCharge" name="totalCharge">

                <button type="button" onclick="calculateCharge()">Calculate Charge</button>
                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>

    <!-- Booking Summary Popup -->
    <div id="summaryPopup" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeSummaryPopup()">×</span>
            <h2>Booking Summary</h2>
            <p>Parking Lot: <span id="summaryLocation"></span></p>
            <p>Start Time: <span id="summaryStartTime"></span></p>
            <p>End Time: <span id="summaryEndTime"></span></p>
            <p>Total Charge: $<span id="summaryTotalCharge"></span></p>
            <button onclick="closeSummaryPopup()">Close</button>
        </div>
    </div>

    <script>
        // Function to open the reservation popup
        function openReservationPopup(location) {
            // Set the location name in the popup
            document.getElementById('locationName').innerText = location;
            document.getElementById('hiddenLocation').value = location;
            document.getElementById('reservationPopup').style.display = 'flex';  // Show the modal
        }

        // Function to close reservation popup
        function closeReservationPopup() {
            document.getElementById('reservationPopup').style.display = 'none';  // Hide the modal
        }

        // Function to calculate the charge based on selected times
        function calculateCharge() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            let totalCharge = 0;

            if (startTime && endTime) {
                const start = new Date(`1970-01-01T${startTime}:00`);
                const end = new Date(`1970-01-01T${endTime}:00`);
                const hours = (end - start) / 3600000; // Difference in hours

                if (hours > 0) {
                    totalCharge = hours * 10; // Charge per hour is $10
                }
            }

            document.getElementById('totalCharge').innerText = totalCharge;
            document.getElementById('hiddenCharge').value = totalCharge;
        }

        // Function to close the summary popup
        function closeSummaryPopup() {
            document.getElementById('summaryPopup').style.display = 'none';
        }

        // Handle the form submission for booking
        document.getElementById('reservationForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent actual form submission

            // Show the summary popup
            const location = document.getElementById('hiddenLocation').value;
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            const totalCharge = document.getElementById('hiddenCharge').value;

            document.getElementById('summaryLocation').innerText = location;
            document.getElementById('summaryStartTime').innerText = startTime;
            document.getElementById('summaryEndTime').innerText = endTime;
            document.getElementById('summaryTotalCharge').innerText = totalCharge;

            document.getElementById('reservationPopup').style.display = 'none';  // Hide reservation popup
            document.getElementById('summaryPopup').style.display = 'flex';  // Show summary popup
        }
    </script>
</body>
</html>
