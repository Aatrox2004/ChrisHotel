<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Rooms Page</title>
  <link rel="stylesheet" href="../../Assets/CSS/General.css">
  <link rel="stylesheet" href="../../Assets/CSS/Room.css">
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
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

<section class="hero-banner">
  <div class="hero-text">
    <h1>Rooms & Suites</h1>
    <p>Experience comfort, elegance, and a touch of luxury at Chris Hotel.</p>
  </div>
</section>

    <section class="rooms-section">
      <div class="container">

        <!-- Deluxe Room -->
        <div class="room-card">
          <div class="room-img">
            <img src="https://themewagon.github.io/sogo/images/img_1.jpg" alt="Deluxe Room">
          </div>
          <div class="room-info">
            <h2>Deluxe Room</h2>
            <p>Spacious and elegantly designed with a sea view, king bed, and private balcony.</p>
            <ul class="room-features">
              <li><i class="fa fa-bed"></i> King Bed</li>
              <li><i class="fa fa-eye"></i> Sea View</li>
              <li><i class="fa fa-coffee"></i> Complimentary Breakfast</li>
              <li><i class="fa fa-wifi"></i> Free Wi-Fi</li>
            </ul>
            <div class="room-buttons">
              <a href="../../Views/Room/DeluxeRoom.php" class="btn-read">Read More</a>
              <a href="../../Views/Reservation/Reservation.php" class="btn-book">Book Now</a>
            </div>
          </div>
        </div>

        <!-- Standard Room -->
        <div class="room-card reverse">
          <div class="room-img">
            <img src="https://themewagon.github.io/sogo/images/img_2.jpg" alt="Standard Room">
          </div>
          <div class="room-info">
            <h2>Standard Room</h2>
            <p>Perfect for business or leisure, featuring a queen bed and city view.</p>
            <ul class="room-features">
              <li><i class="fa fa-bed"></i> Queen Bed</li>
              <li><i class="fa fa-building"></i> City View</li>
              <li><i class="fa fa-cutlery"></i> Free Breakfast</li>
              <li><i class="fa fa-wifi"></i> Free Wi-Fi</li>
            </ul>
            <div class="room-buttons">
              <a href="../../Views/Room/StandardRoom.php" class="btn-read">Read More</a>
              <a href="../../Views/Reservation/Reservation.php" class="btn-book">Book Now</a>
            </div>
          </div>
        </div>

      </div>
    </section>



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
