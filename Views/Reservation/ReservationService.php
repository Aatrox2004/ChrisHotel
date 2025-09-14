<!-- Reservation Form -->
  <form class="reservation-form" action="<?php echo BASE_URL; ?>index.php?url=Reservation/Process" method="POST" onsubmit="return validateForm()">
    <input type="hidden" id="reservation-checkin" name="checkin" required>
    <input type="hidden" id="reservation-checkout" name="checkout" required>

    <label for="reservation-name">Full Name</label>
    <input type="text" id="reservation-name" name="name" required>

    <label for="reservation-room">Room Type</label>
    <select id="reservation-room" name="room">
      <option value="Deluxe">Deluxe</option>
      <option value="Standard">Standard</option>
      <option value="Suite">Suite</option>
    </select>

    <label for="reservation-guests">Guests</label>
    <input type="number" id="reservation-guests" name="guests" min="1" max="5" required>

    <h4>Optional Services:</h4>
    <label><input type="checkbox" name="services[]" value="Breakfast"> Breakfast (+$20)</label><br>
    <label><input type="checkbox" name="services[]" value="Airport Pickup"> Airport Pickup (+$50)</label><br>
    <label><input type="checkbox" name="services[]" value="Late Checkout"> Late Checkout (+$30)</label>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit" class="reservation-btn">Proceed to Payment</button>
  </form>

  
  .reservation-form {
    max-width: 600px;
    margin: 2rem auto;
    background: #f9f9f9;
    padding: 2rem;
    border-radius: 8px;
}

.reservation-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.reservation-form input,
.reservation-form select {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.reservation-form button {
    background: #f9b233;
    padding: 0.75rem 1.5rem;
    border: none;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
}