-- 1. User Table --
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birthday DATE,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    contact_number VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,  -- Email as the login ID
    password VARCHAR(255) NOT NULL,  -- Encrypted password
    is_admin BOOLEAN DEFAULT FALSE, -- Indicates if the user is an admin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Vehicles Table --
CREATE TABLE vehicles (
    vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,  -- Foreign key to users table
    vehicle_type VARCHAR(50) NOT NULL,
    vehicle_number VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 3. Locations Table --
CREATE TABLE locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(100) NOT NULL UNIQUE -- e.g., Colombo, Kandy, Gall
);

-- 4. Parking Lots Table --
CREATE TABLE parking_lots (
    lot_id INT AUTO_INCREMENT PRIMARY KEY,
    location_id INT,  -- Foreign key to the locations table
    lot_number VARCHAR(50) NOT NULL UNIQUE,  -- Unique parking lot number
    ev_charger_available BOOLEAN DEFAULT FALSE,  -- EV charger availability
    category ENUM('4-wheelers', '3-wheelers', '2-wheelers') NOT NULL,  -- Lot category
    price DECIMAL(10, 2) NOT NULL,  -- Price for reserving the lot
    status ENUM('Available', 'Occupied', 'Maintenance') DEFAULT 'Available', -- Lot status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- 5. Reservations Table --
CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,  -- Foreign key to the users table
    lot_id INT,  -- Foreign key to the parking_lots table
    vehicle_id INT,  -- Foreign key to vehicles table
    vehicle_number VARCHAR(20) NOT NULL,  -- Vehicle number for reservation
    reserved_from DATETIME,  -- Start date and time of reservation
    reserved_to DATETIME,  -- End date and time of reservation
    status ENUM('Booked', 'Cancelled', 'Completed') DEFAULT 'Booked',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (lot_id) REFERENCES parking_lots(lot_id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE
);

-- 6. Reviews Table --
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    review_text TEXT, 
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

);

-- 7. Contact Form Submissions Table
CREATE TABLE ContactSubmissions (
    SubmissionID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    ContactNumber VARCHAR(15) NOT NULL,
    Message TEXT NOT NULL,
    Status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
    SubmittedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Login Activity Table --
CREATE TABLE login_activity (
    login_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,  -- Foreign key to users table
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP, -- Login timestamp
    logout_time DATETIME, -- Logout timestamp
    ip_address VARCHAR(45), -- User's IP address (supports IPv6)
    user_agent TEXT, -- Browser or device details
    status ENUM('Success', 'Failed') DEFAULT 'Success', -- Login attempt status
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

ALTER TABLE vehicles DROP INDEX vehicle_number;
ALTER TABLE vehicles ADD UNIQUE KEY user_vehicle_unique (user_id, vehicle_number);