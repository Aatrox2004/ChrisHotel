<?php
date_default_timezone_set('Asia/Singapore');

// Ensure booking exists
if (!isset($_SESSION['booking'])) {
    header('Location: reservation.php');  // Redirect if no booking
    exit;
}

$booking = $_SESSION['booking'];
?>

<div class="payment-container clearfix">
  <div class="payment-card">
    <h3 class="payment-title">Booking Summary</h3>
    <dl class="payment-dl">
      <dt>Check-in Date:</dt>
      <dd><?= htmlspecialchars($booking['checkin']) ?></dd>
      <dt>Check-out Date:</dt>
      <dd><?= htmlspecialchars($booking['checkout']) ?></dd>
      <dt>Room Type:</dt>
      <dd><?= htmlspecialchars($booking['room']) ?></dd>
      <dt>Guests:</dt>
      <dd><?= htmlspecialchars($booking['guests']) ?></dd>
      <dt>Total Price:</dt>
      <dd>$<?= htmlspecialchars(number_format($booking['total'], 2)) ?></dd>
    </dl>
  </div>

  <div class="payment-card">
    <h3 class="payment-title">Payment Details</h3>
    <form class="payment-form" action="<?php echo BASE_URL; ?>Controller/PaymentController.php" method="POST">
      <input type="hidden" name="action" value="pay">
      <label for="payment-card-number">Card Number</label>
      <input type="text" id="payment-card-number" name="card_number" required>
      <label for="payment-expiry">Expiry Date</label>
      <input type="text" id="payment-expiry" name="expiry" required>
      <label for="payment-cvv">CVV</label>
      <input type="text" id="payment-cvv" name="cvv" required>
      <button type="submit" class="payment-btn">Pay $<?= htmlspecialchars(number_format($booking['total'], 2)) ?></button>
    </form>
  </div>
</div>