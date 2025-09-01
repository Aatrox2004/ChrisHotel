<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Profile - Chris Hotel</title>
    <link rel="stylesheet" href="../../Assets/CSS/General.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .profile-card {
            background: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-card h2 {
            margin-top: 0;
            color: #f9b233;
        }
        .profile-details {
            margin-top: 1.5rem;
        }
        .profile-details p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }
        .edit-btn {
            margin-top: 1.5rem;
            padding: 0.75rem 1.5rem;
            background: #f9b233;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
            text-decoration: none;
        }
        .edit-btn:hover {
            background: #e0a322;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
        <strong><a href="../../Views/Home.php" title="Chris Hotel Home Page">Chris Hotel</a></strong>
        </div>
        <nav class="nav-links">
        <a href="../../Views/Room/StandardRoom.php" title="Room Page">Rooms</a>
        <a href="../../Views/Reservation/Reservation.php" title="Reservation Page">Reservation</a>
        <a href="../../Views/About.php" title="About Page">About</a>
        <a href="../../Views/Contact.php" title="Contact Page">Contact</a>
        <?php 
        if(isset($_SESSION['user_id'])) { ?>
            <a href="../../Views/User/Logout.php" title="Logout"><i class="fa fa-sign-out"></i> Logout</a>
        <?php } else { ?>
            <a href="../../Views/User/Login.php" title="Login Page"><i class="fa fa-user"></i> Login</a>
        <?php } ?>
        </nav>
    </header>
    <div class="container">
        <div class="profile-card">
            <h2>User Profile</h2>
            <div class="profile-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($userName) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars(isset($booking['email']) ? $booking['email'] : 'Not provided') ?></p>
                <p><strong>Total Spent:</strong> $<?= htmlspecialchars(number_format($booking['total'], 2)) ?></p>
                <p><strong>Last Booking:</strong> <?= htmlspecialchars($booking['checkin'] . ' to ' . $booking['checkout']) ?></p>
            </div>
            <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
        </div>
    </div>
    <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-columns">
        <div class="footer-column">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Rooms</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Discover</h4>
          <ul>
            <li><a href="#">The Rooms & Suites</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Restaurant</a></li>
          </ul>
        </div>
        <div class="footer-column contact-info">
          <h4>Contact Info</h4>
          <p><strong>Address:</strong> 198 West 21th Street,<br>Suite 721 New York, NY 10016</p>
          <p><strong>Phone:</strong> (+1) 435 3533</p>
          <p><strong>Email:</strong> info@domain.com</p>
        </div>
        <div class="footer-column newsletter">
          <h4>Newsletter</h4>
          <p>Sign up for our newsletter</p>
          <form action="#" class="newsletter-form">
            <input type="email" placeholder="Your email" required>
            <button type="submit">Send</button>
          </form>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <span id="year"></span> Sogo Hotel. All rights reserved.</p>
        <div class="social-icons">
          <a href="#"><i class="fa fa-tripadvisor"></i></a>
          <a href="#"><i class="fa fa-facebook"></i></a>
          <a href="#"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-linkedin"></i></a>
          <a href="#"><i class="fa fa-vimeo"></i></a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>