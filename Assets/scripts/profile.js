// profile.js
function populateVehicles(vehicles) {
    const vehicleContainer = document.getElementById('vehicle-container');
    vehicleContainer.innerHTML = ''; // Clear previous fields

    vehicles.forEach((vehicle, index) => {
        console.log(vehicle);
        vehicleContainer.innerHTML += `
            <div class="form-group vehicle-group" id="vehicle-${index}">
                <label>Vehicle Type</label>
                <input type="hidden" name="vehicle_id[]" value="${vehicle.vehicle_id}"/>    <!-- Add hidden input for vehicle ID -->
                <input type="text" name="vehicle_type[]" value="${vehicle.vehicle_type}" required>
                <label>Vehicle Number</label>
                <input type="text" name="vehicle_number[]" value="${vehicle.vehicle_number}" required>
                <button type="button" onclick="removeVehicleField(${index})" class="remove-btn">Remove</button>
            </div>
        `;
    });
}

function addVehicleField() {
    const vehicleContainer = document.getElementById('vehicle-container');
    const index = vehicleContainer.children.length;

    vehicleContainer.innerHTML += `
        <div class="form-group vehicle-group" id="vehicle-${index}">
            <label>Vehicle Type</label>
            <input type="text" name="vehicle_type[]" required>
            <label>Vehicle Number</label>
            <input type="text" name="vehicle_number[]" required>
            <button type="button" onclick="removeVehicleField(${index})" class="remove-btn">Remove</button>
        </div>
    `;
}

function removeVehicleField(index) {
    const field = document.getElementById(`vehicle-${index}`);
    field.remove();
}

async function openUpdateModal() {
    const response = await fetch('../API/get_user_profile.php');
    const result = await response.json();

    if (result.status === 'success') {
        const user = result.user;
        const vehicles = result.vehicles || [];

        // Pre-fill user info
        document.getElementById('user-id').value = user.user_id; // Add user ID to hidden input
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
