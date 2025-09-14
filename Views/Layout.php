<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Chris Hotel'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Assets/CSS/General.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <?php if (isset($customCSS) && !empty($customCSS)): ?>
      <style>
        <?= $customCSS ?>
      </style>
    <?php endif; ?>
    
    <?php if (isset($cssFile) && !empty($cssFile)): ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>Assets/CSS/<?= $cssFile ?>"> 
    <?php endif; ?>
  </head>
  <body>
    <header>
      <div class="logo">
        <strong><a href="<?php echo BASE_URL; ?>index.php" title="Chris Hotel Home Page">Chris Hotel</a></strong>
      </div>
      <nav class="nav-links">
        <a href="<?php echo BASE_URL; ?>index.php?url=Rooms" title="Rooms">Rooms</a>
        <a href="<?php echo BASE_URL; ?>index.php?url=Reservation" title="Reservation">Reservation</a>
        <a href="<?php echo BASE_URL; ?>index.php?url=About" title="About">About</a>
        <a href="<?php echo BASE_URL; ?>index.php?url=Contact" title="Contact">Contact</a>
        <?php if(isset($_SESSION['user_id'])) { ?>
          <a href="<?php echo BASE_URL; ?>index.php?url=Login/Process&action=logout" title="Logout"><i class="fa fa-sign-out"></i> Logout</a>
        <?php } else { ?>
          <a href="<?php echo BASE_URL; ?>index.php?url=Login" title="Login"><i class="fa fa-user"></i> Login</a>
        <?php } ?>
      </nav>
    </header>

    <main class="main-content">
      <?php echo $content; ?>
    </main>

    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-columns">
          <div class="footer-column">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="<?php echo BASE_URL; ?>index.php?url=About">About Us</a></li>
              <li><a href="<?php echo BASE_URL; ?>Views/Terms.php">Terms & Conditions</a></li>
              <li><a href="<?php echo BASE_URL; ?>Views/Privacy.php">Privacy Policy</a></li>
              <li><a href="<?php echo BASE_URL; ?>index.php?url=Rooms">Rooms</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h4>Discover</h4>
            <ul>
              <li><a href="<?php echo BASE_URL; ?>index.php?url=Rooms">The Rooms & Suites</a></li>
              <li><a href="<?php echo BASE_URL; ?>index.php?url=About">About Us</a></li>
              <li><a href="<?php echo BASE_URL; ?>index.php?url=Contact">Contact Us</a></li>
              <li><a href="<?php echo BASE_URL; ?>Views/Restaurant.php">Restaurant</a></li>
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
          <p>&copy; <span id="year"><?php echo date('Y'); ?></span> Chris Hotel. All rights reserved.</p>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-vimeo"></i></a>
          </div>
        </div>
      </div>
    </footer>
    <?php if (isset($jsFile) && !empty($jsFile)): ?>
      <script src="<?= BASE_URL ?>/assets/js/<?= $jsFile ?>"></script>
    <?php endif; ?>
  </body>
</html>