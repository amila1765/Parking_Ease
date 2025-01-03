<div id="updateProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateModal()">&times;</span>
        <h2>Update Profile</h2>
        <form id="update-profile-form">

            <!-- Hidden field for user ID -->
            <input type="hidden" id="user-id" value="">

            <!-- User Info Fields -->
            <div class="form-group">
                <label for="update-first-name">First Name</label>
                <input type="text" id="update-first-name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="update-last-name">Last Name</label>
                <input type="text" id="update-last-name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="update-birthday">Birthday</label>
                <input type="date" id="update-birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="update-gender">Gender</label>
                <select id="update-gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="update-contact">Contact Number</label>
                <input type="text" id="update-contact" name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="update-email">Email (You can't update the email)</label>
                <input type="email" id="update-email" name="email" disabled>
            </div>

            <!-- Vehicle Info Fields -->
            <h3>Your Vehicles</h3>
            <div id="vehicle-container">
                <!-- Vehicles dynamically added here -->
            </div>
            <!--button type="button" onclick="addVehicleField()" class="add-vehicle-btn">Add Vehicle</button-->

            <button type="button" class="btn btn-primary" id="update-profile-btn">Update Profile</button>

        </form>
    </div>
</div>

<!-- Delete Profile Modal -->
<div id="deleteProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Confirm Profile Deletion</h2>
        <p>Enter your password to confirm profile deletion:</p>
        <form id="delete-profile-form">
            <div class="form-group">
                <label for="delete-password">Password</label>
                <input type="password" id="delete-password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Delete Profile</button>
        </form>
    </div>
</div>


<script>
    async function updateUserProfile() {
    const userId = document.getElementById('user-id').value; // FIX: Read the user ID
    console.log("User ID:", userId); // Debugging log

    if (!userId) {
        alert("User ID is missing!");
        return;
    }

    const firstName = document.getElementById('update-first-name').value;
    const lastName = document.getElementById('update-last-name').value;
    const birthday = document.getElementById('update-birthday').value;
    const gender = document.getElementById('update-gender').value;
    const contact = document.getElementById('update-contact').value;
    //const email = document.getElementById('update-email').value;

    const vehicles = [];
    document.querySelectorAll('.vehicle-group').forEach((group) => {
        const id = group.querySelector('input[name="vehicle_id[]"]').value;
        const type = group.querySelector('input[name="vehicle_type[]"]').value;
        const number = group.querySelector('input[name="vehicle_number[]"]').value;

        vehicles.push({ vehicle_id: id, vehicle_type: type, vehicle_number: number });
    });

    const payload = {
        user_id: userId, // FIX: Include user ID in payload
        first_name: firstName,
        last_name: lastName,
        birthday: birthday,
        gender: gender,
        contact_number: contact,
        //email: email,
        vehicles: vehicles
    };

    console.log("Payload:", payload); // Debugging log

    const response = await fetch('../API/update_user_vehicle.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
        });

        const result = await response.json();
        alert(result.message);
        if (result.status === 'success') {
            location.reload(); // Refresh data
        }
}

    // Attach function to Update button click event
    document.getElementById('update-profile-btn').addEventListener('click', updateUserProfile);

    async function openUpdateModal() {
    const response = await fetch('../API/get_user_profile.php');
    const result = await response.json();

    if (result.status === 'success') {
        const user = result.user;
        const vehicles = result.vehicles || [];

        // Populate user ID in the hidden field
        document.getElementById('user-id').value = user.user_id; // FIX: Set user ID correctly

        // Pre-fill user info
        document.getElementById('update-first-name').value = user.first_name;
        document.getElementById('update-last-name').value = user.last_name;
        document.getElementById('update-birthday').value = user.birthday;
        document.getElementById('update-gender').value = user.gender;
        document.getElementById('update-contact').value = user.contact_number;
        document.getElementById('update-email').value = user.email;

        // Populate vehicle info
        populateVehicles(vehicles);

        // Show modal
        document.getElementById('updateProfileModal').style.display = 'block';
        document.body.classList.add('modal-open');
    } else {
        alert(result.message);
    }
}


    function addVehicleField(vehicle = { vehicle_id: '', vehicle_type: '', vehicle_number: '' }) {
    const container = document.getElementById('vehicle-container');

    const vehicleGroup = document.createElement('div');
    vehicleGroup.classList.add('vehicle-group');
    vehicleGroup.innerHTML = `
        <input type="hidden" name="vehicle_id[]" value="${vehicle.vehicle_id}">
        <input type="text" name="vehicle_type[]" placeholder="Vehicle Type" value="${vehicle.vehicle_type}" required>
        <input type="text" name="vehicle_number[]" placeholder="Vehicle Number" value="${vehicle.vehicle_number}" required>
        
    `;  // <button type="button" class="remove-vehicle-btn" onclick="removeVehicleField(this)">Remove</button>
    container.appendChild(vehicleGroup);
    }

    function removeVehicleField(button) {
        const container = document.getElementById('vehicle-container');
        container.removeChild(button.parentNode);
    }


</script>