<?php
require_once "../../Ultis/SecurityUtils.php";
secure_session_start();

// Privilege check: must have a booking
if (!isset($_SESSION['booking'])) {
    header("Location: ../User/Login.php");
    exit("Unauthorized access: Please log in and make a booking first.");
}

$booking = $_SESSION['booking'];
?>
<h2>Checkout</h2>
<form action="../../Controller/PaymentControl.php" method="POST">
  <input type="hidden" name="action" value="checkout">
  <input type="hidden" name="amount" value="<?= htmlspecialchars($booking['amount']) ?>">

  <label>Gateway:</label>
  <select name="gateway" required>
    <option value="stripe">Stripe</option>
    <option value="paypal">PayPal</option>
  </select><br><br>

  <label>Card Number:</label>
  <input type="text" name="card" pattern="\d{16}" required><br><br>

  <label>Expiry (MM/YY):</label>
  <input type="text" name="expiry" pattern="\d{2}/\d{2}" required><br><br>

  <label>CVV:</label>
  <input type="password" name="cvv" pattern="\d{3}" required><br><br>

  <button type="submit">Pay Now</button>
</form>
