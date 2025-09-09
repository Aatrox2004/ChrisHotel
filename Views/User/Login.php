<div class="auth-container">
  <div class="auth-card">

    <!-- Tabs -->
    <div class="auth-tabs">
      <button type="button" class="auth-tab-btn active" id="auth-tab-login">Login</button>
      <button type="button" class="auth-tab-btn" id="auth-tab-register">Register</button>
    </div>

    <!-- Login form -->
    <form class="auth-form active" id="auth-login-form" 
          action="<?php echo BASE_URL; ?>index.php?url=Login/Process" method="POST">
      <input type="hidden" name="action" value="login">

      <label for="auth-login-email">Email</label>
      <input type="email" id="auth-login-email" name="email" class="form-control" required>

      <label for="auth-login-password">Password</label>
      <div class="auth-password-wrapper">
        <input type="password" id="auth-login-password" name="password" class="form-control" required>
        <i class="fa fa-eye" id="auth-toggle-login-password"></i>
      </div>

      <button type="submit" class="auth-btn login">Login</button>
    </form>

    <!-- Register form -->
    <form class="auth-form" id="auth-register-form" 
          action="<?php echo BASE_URL; ?>index.php?url=Login/Process" method="POST">
      <input type="hidden" name="action" value="register">

      <label for="auth-register-fullname">Full Name</label>
      <input type="text" id="auth-register-fullname" name="fullname" class="form-control" required>

      <label for="auth-register-email">Email</label>
      <input type="email" id="auth-register-email" name="email" class="form-control" required>

      <label for="auth-register-password">Password</label>
      <div class="auth-password-wrapper">
        <input type="password" id="auth-register-password" name="password" class="form-control" required>
        <i class="fa fa-eye" id="auth-toggle-register-password"></i>
      </div>

      <label for="auth-register-confirm">Confirm Password</label>
      <div class="auth-password-wrapper">
        <input type="password" id="auth-register-confirm" name="confirm_password" class="form-control" required>
        <i class="fa fa-eye" id="auth-toggle-register-confirm"></i>
      </div>

      <button type="submit" class="auth-btn register">Register</button>
    </form>

  </div>
</div>

<script>
  // Tab switch
  const btnLogin = document.getElementById('auth-tab-login');
  const btnRegister = document.getElementById('auth-tab-register');
  const formLogin = document.getElementById('auth-login-form');
  const formRegister = document.getElementById('auth-register-form');

  btnLogin.addEventListener('click', () => {
    btnLogin.classList.add('active');
    btnRegister.classList.remove('active');
    formLogin.classList.add('active');
    formRegister.classList.remove('active');
  });

  btnRegister.addEventListener('click', () => {
    btnRegister.classList.add('active');
    btnLogin.classList.remove('active');
    formRegister.classList.add('active');
    formLogin.classList.remove('active');
  });

  // Password toggle
  function setupToggle(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;
    icon.addEventListener('click', () => {
      input.type = input.type === 'password' ? 'text' : 'password';
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  }

  setupToggle('auth-login-password', 'auth-toggle-login-password');
  setupToggle('auth-register-password', 'auth-toggle-register-password');
  setupToggle('auth-register-confirm', 'auth-toggle-register-confirm');
</script>
