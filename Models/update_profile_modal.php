<!-- update_profile_modal.php -->
<div id="updateProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateModal()">&times;</span>
        <h2>Update Profile</h2>
        <form id="update-profile-form">
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
                <label for="update-email">Email</label>
                <input type="email" id="update-email" name="email" required>
            </div>

            <!-- Vehicle Info Fields -->
            <h3>Your Vehicle</h3>
            <div class="form-group">
                <label for="update-vehicle-type">Vehicle Type</label>
                <input type="text" id="update-vehicle-type" name="vehicle_type">
            </div>
            <div class="form-group">
                <label for="update-vehicle-number">Vehicle Number</label>
                <input type="text" id="update-vehicle-number" name="vehicle_number">
            </div>

            <button type="submit" class="submit-btn">Update Profile</button>
        </form>
    </div>
</div>