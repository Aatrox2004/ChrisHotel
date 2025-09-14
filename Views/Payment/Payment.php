<div class="payment-container clearfix">
  <?php if (isset($reservation)): ?>
    <div class="payment-card">
      <h3 class="payment-title">Booking Summary</h3>
      <dl class="payment-dl">
        <dt>Check-in Date:</dt>
        <dd><?= htmlspecialchars($reservation['checkIn']) ?></dd>

        <dt>Check-out Date:</dt>
        <dd><?= htmlspecialchars($reservation['checkOut']) ?></dd>

        <dt>Room Type:</dt>
        <dd><?= htmlspecialchars($reservation['roomName']) ?> (<?= htmlspecialchars($reservation['roomType']) ?>)</dd>

        <dt>Guests:</dt>
        <dd>
          Adults: <?= htmlspecialchars($reservation['adults']) ?>,
          Children: <?= htmlspecialchars($reservation['children']) ?>
        </dd>

        <dt>Total Price:</dt>
        <dd>$<?= htmlspecialchars(number_format($reservation['totalAmount'], 2)) ?></dd>
      </dl>
    </div>

    <div class="payment-card">
      <h3 class="payment-title">Payment Details</h3>
      <form class="payment-form" action="<?php echo BASE_URL; ?>index.php?url=Payment" method="POST">
        <input type="hidden" name="action" value="checkout">
        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservationId']) ?>">

        <label for="payment-card-number">Card Number</label>
        <input type="text" id="payment-card-number" name="card" required>

        <label for="payment-expiry">Expiry Date</label>
        <input type="text" id="payment-expiry" name="expiry" required>

        <label for="payment-cvv">CVV</label>
        <input type="text" id="payment-cvv" name="cvv" required>

        <button type="submit" class="payment-btn">
          Pay $<?= htmlspecialchars(number_format($reservation['totalAmount'], 2)) ?>
        </button>
      </form>
    </div>
  <?php else: ?>
    <p>No reservation details found. Please make a reservation first.</p>
  <?php endif; ?>
</div>
