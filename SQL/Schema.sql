DROP TABLE reservation_services;
DROP TABLE payments;
DROP TABLE reservations;
DROP TABLE services;
DROP TABLE rooms;
DROP TABLE users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    role ENUM('guest', 'admin') DEFAULT 'guest',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(50) NOT NULL UNIQUE,
    room_type ENUM('Standard', 'Deluxe', 'Family Suite') NOT NULL,
    room_picture VARCHAR(255) NOT NULL,
    max_occupancy int(10) NOT NULL,
    bed_type text NOT NULL,
    size text NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('Available', 'Booked', 'Occupied', 'Cleaning', 'Maintenance') DEFAULT 'Available',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE
);


CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('PayPal', 'Stripe', 'E-Wallet', 'Online Banking') NOT NULL,
    payment_status ENUM('Pending', 'Completed', 'Refunded', 'Failed') DEFAULT 'Pending',
    paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    refund_amount DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id) ON DELETE CASCADE

    ALTER TABLE payments 
    ADD COLUMN refund_date DATETIME NULL AFTER refund_amount;
);

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE reservation_services (
    reservation_id INT NOT NULL,
    service_id INT NOT NULL,
    PRIMARY KEY (reservation_id, service_id),
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);

INSERT INTO `rooms` (`room_id`, `room_name`, `room_type`, `room_picture`, `max_occupancy`, `bed_type`, `size`, `price`, `status`, `description`, `created_at`) VALUES
(1, 'Standard King Room', 'Standard', 'Assets/Images/room1.jpg', 5, '1 Crib & 1 King Bed', '24m²', 100.00, 'Available', 'Cozy room with a single bed and basic amenities.', '2025-09-10 15:21:34'),
(2, 'Deluxe Queen Room', 'Deluxe', 'Assets/Images/room2.jpg', 5, '1 Crib & 1 King Bed', '28m²', 200.00, 'Available', 'Spacious room with a king bed and city view.', '2025-09-10 15:21:34'),
(3, 'Family Suite', 'Family Suite', 'Assets/Images/room3.jpg', 5, '1 Crib & 1 Twin Bed', '28m²', 350.00, 'Available', 'Large suite with two bedrooms and a kitchenette.', '2025-09-10 15:21:34'),
(4, '404', 'Standard', 'Assets/Images/room4.jpg', 5, '1 Crib & 1 King Bed', '32m²', 400.00, 'Available', 'Comfortable room with modern decor.', '2025-09-10 15:21:34');