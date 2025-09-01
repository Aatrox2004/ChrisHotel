<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../Assets/CSS/General.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper i {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: gray;
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

  <!-- Login/Register Form -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <ul class="nav nav-tabs" id="authTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab">Register</a>
            </li>
          </ul>

          <div class="tab-content mt-3">
            <!-- Login Tab -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
              <form action="login.php" method="POST">
                <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3 password-wrapper">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" id="loginPassword" required>
                  <i class="fa fa-eye" id="toggleLoginPassword"></i>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
              </form>
            </div>

            <!-- Register Tab -->
            <div class="tab-pane fade" id="register" role="tabpanel">
              <form action="register.php" method="POST">
                <div class="mb-3">
                  <label>Full Name</label>
                  <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3 password-wrapper">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" id="registerPassword" required>
                  <i class="fa fa-eye" id="toggleRegisterPassword"></i>
                </div>
                <div class="mb-3 password-wrapper">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" class="form-control" id="registerConfirmPassword" required>
                  <i class="fa fa-eye" id="toggleRegisterConfirmPassword"></i>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br><br>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      icon.addEventListener('click', () => {
        if (input.type === "password") {
          input.type = "text";
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
        } else {
          input.type = "password";
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
        }
      });
    }
    togglePassword("loginPassword", "toggleLoginPassword");
    togglePassword("registerPassword", "toggleRegisterPassword");
    togglePassword("registerConfirmPassword", "toggleRegisterConfirmPassword");
  </script>
</body>
</html>
