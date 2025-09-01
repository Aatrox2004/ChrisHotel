<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reservation Page</title>
  <link rel="stylesheet" href="../../Assets/CSS/General.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <style>
    form {
      max-width: 500px;
      margin: auto;
      background: #f9f9f9;
      padding: 2rem;
      border-radius: 8px;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1.5rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      background: #f9b233;
      padding: 0.75rem 1.5rem;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
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

  <section class="section">
    <h2 class="section-title">Make a Reservation</h2>
    <form action="./DesignPatterns/Strategy.php" method="POST">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="checkin">Check-in Date</label>
      <input type="date" id="checkin" name="checkin" required>

      <label for="checkout">Check-out Date</label>
      <input type="date" id="checkout" name="checkout" required>

      <label for="room">Room Type</label>
      <select id="room" name="room">
        <option value="Deluxe">Deluxe</option>
        <option value="Standard">Standard</option>
        <option value="Suite">Suite</option>
      </select>

      <label for="guests">Guests</label>
      <input type="number" id="guests" name="guests" min="1" max="5" required>

      <button type="submit">Proceed to Payment</button>
    </form>
  </section>

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
  <!-- <script>
    setTimeout(function () {
      alert("Timeout for reservation");
      window.location.href = "home.html";
    }, 300000); // 10000 ms = 10 seconds
  </script> -->
</body>
</html>
