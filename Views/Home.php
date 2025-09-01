<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chris Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../Assets/CSS/General.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
      .hero {
        display: grid;
        place-items: center;
        height: 90vh;
        background: url('https://themewagon.github.io/sogo/images/hero_1.jpg') center/cover no-repeat;
        text-align: center;
        color: #fff;
      }

      .hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
      }

      .btn {
        padding: 0.75rem 1.5rem;
        background: #f9b233;
        color: #000;
        border: none;
        font-weight: bold;
        cursor: pointer;
        border-radius: 5px;
      }

      .section {
        padding: 4rem 2rem;
        max-width: 1200px;
        margin: auto;
      }

      .section-title {
        text-align: center;
        margin-bottom: 2rem;
      }

      .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
      }

      .room {
        border: 1px solid #ccc;
        border-radius: 5px;
        overflow: hidden;
        background: #fff;
      }

      .room img {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }

      .room-content {
        padding: 1rem;
      }

      .footer {
        background: #111;
        color: #eee;
        text-align: center;
        padding: 2rem;
      }

      @media (max-width: 768px) {
        .hero h1 {
          font-size: 2rem;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <div class="logo">
        <strong><a href="../Views/Home.php" title="Chris Hotel Home Page">Chris Hotel</a></strong>
      </div>
      <nav class="nav-links">
        <a href="../Views/Room/StandardRoom.php" title="Room Page">Rooms</a>
        <a href="../Views/Reservation/Reservation.php" title="Reservation Page">Reservation</a>
        <a href="../Views/About.php" title="About Page">About</a>
        <a href="../Views/Contact.php" title="Contact Page">Contact</a>
        <?php 
        if(isset($_SESSION['user_id'])) { ?>
            <a href="../Views/User/Logout.php" title="Logout"><i class="fa fa-sign-out"></i> Logout</a>
        <?php } else { ?>
            <a href="../Views/User/Login.php" title="Login Page"><i class="fa fa-user"></i> Login</a>
        <?php } ?>
      </nav>
    </header>
    <section class="hero">
      <div>
        <h1>Welcome to Chris Hotel</h1>
        <a href="#rooms" class="btn">Book Now</a>
      </div>
    </section>

    <section id="rooms" class="section">
      <h2 class="section-title">Our Rooms</h2>
      <div class="room-grid">
        <div class="room">
          <img src="https://themewagon.github.io/sogo/images/img_1.jpg" alt="Room 1" />
          <div class="room-content">
            <h3>Deluxe Room</h3>
            <p>Comfortable and spacious room with sea view.</p>
          </div>
        </div>
        <div class="room">
          <img src="https://themewagon.github.io/sogo/images/img_2.jpg" alt="Room 2" />
          <div class="room-content">
            <h3>Standard Room</h3>
            <p>Affordable luxury for budget-conscious travelers.</p>
          </div>
        </div>
        <div class="room">
          <img src="https://themewagon.github.io/sogo/images/img_3.jpg" alt="Room 3" />
          <div class="room-content">
            <h3>Family Suite</h3>
            <p>Spacious suite perfect for families with children.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="section">
      <h2 class="section-title">About Us</h2>
      <p style="text-align:center; max-width:800px; margin:auto">Chris Hotel offers world-class hospitality with a touch of elegance. Nestled in the heart of the city, we bring you a blend of luxury and comfort for both business and leisure travelers.</p>
    </section>

    <section id="contact" class="section">
      <h2 class="section-title">Contact Us</h2>
      <p style="text-align:center; max-width:800px; margin:auto">Feel free to reach out via email at contact@sogohotel.com or call us at +123 456 7890.</p>
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
  </body>
  <script>
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
</html>