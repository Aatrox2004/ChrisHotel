<form action="<?php echo BASE_URL; ?>index.php?url=Reservation/Process" method="POST" onsubmit="return validateForm()">
  <section class="reservation-section">
    <!-- Name input -->
    <div class="form-group">
      <label for="reservation-name">Guest Name:</label>
      <input type="text" id="reservation-name" name="name" required>
    </div>

    <!-- Date selection -->
    <div class="selection-container">
      <div class="selection-container-left">
        <div class="date-picker-container">
          <div class="date-picker-input">
            <label for="date-range">Select Dates:</label>
            <input type="text" class="date-range" id="date-range" readonly placeholder="Check-in → Check-out" onclick="toggleCalendar()">
          </div>
          <input type="hidden" id="reservation-id" name="reservationID">
          <input type="hidden" id="reservation-checkin" name="checkin">
          <input type="hidden" id="reservation-checkout" name="checkout">
          <input type="hidden" id="reservation-adults" name="adults">
          <input type="hidden" id="reservation-children" name="children">
          <input type="hidden" id="reservation-room" name="roomType">
          <input type="hidden" id="reservation-room-price" name="room_price">
          <input type="hidden" id="room-id" name="roomId">

          <div class="calendar-popup" id="calendarPopup">
            <span class="close-icon" onclick="closeCalendar()">&times;</span>
            <div class="calendar-header">
              <button type="button" onclick="prevMonth()" class="prev-button">&#10094;</button>
              <span id="calendarTitle"></span>
              <button type="button" onclick="nextMonth()" class="next-button">&#10095;</button>
            </div>
            <div id="calendar-body" class="calendar-body"></div>
          </div>
        </div>

        <!-- Rooms selection -->
        <div class="rooms-selector">
          <div class="rooms-selector-container" onclick="toggleRoomsPopup()">
            <i class="fa fa-bed"></i>
            <span id="rooms-label" class="rooms-label">2 Adults, 0 Children</span>
          </div>
          <div class="rooms-popup" id="roomsPopup">
            <div class="rooms-header">
              <h3>ROOMS</h3>
            </div>
            <div id="rooms-details" class="rooms-details"></div>
            <p class="accommodate-error">Your selected room type can accommodate a maximum of 5 occupants</p>
            <button type="button" onclick="saveRooms()" class="save-btn">SAVE CHANGES</button>
          </div>
        </div>
      </div>

      <div class="selection-container-right"> 
        <div class="cart-container"> 
          <div class="selection-cart" onclick="toggleCartPopup()"> 
            <i class="fa fa-shopping-cart"></i> 
            <i class="fa total-amount" id="total-amount"></i> 
            <i class="fa fa-angle-down"></i> 
          </div> 
          <div class="cart-popup" id="cartPopup"> 
            <h3>Your Selection</h3> 
            <div id="cart-details" class="cart-details"></div>
            <button type="button" onclick="clearCart()" class="clear-cart-btn">Clear Cart</button> 
          </div> 
        </div> 
      </div>
    </div>

    <div class="rooms-container" id="roomsContainer"></div>
  </section>
  <div class="form-checkout flex">
    <div class="selected-room">
      <h3>Selected Room:</h3>
      <div id="selected-room-details"></div>
    </div>
    <button type="submit" class="submit-btn">Proceed to Checkout</button>
  </div>
</form>

<script>
  const BASE_URL = '<?php echo rtrim(BASE_URL, "/") . "/"; ?>';
</script>