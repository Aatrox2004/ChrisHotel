<form action="<?php echo BASE_URL; ?>index.php?url=Reservation/Process" method="POST" onsubmit="return validateForm()">
  <section class="reservation-section">
    <h2 class="reservation-title">Make a Reservation</h2>

    <div class="selection-container">
      <div class="selection-container-left">
        <div class="date-picker-container">
          <label for="date-range">Select Dates:</label>
          <input type="text" id="date-range" readonly placeholder="Check-in → Check-out" onclick="toggleCalendar()">
          <input type="hidden" id="reservation-checkin" name="checkin">
          <input type="hidden" id="reservation-checkout" name="checkout">
          <input type="hidden" id="reservation-guests" name="guests">
          <input type="hidden" id="reservation-rooms" name="rooms">

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

        <div class="rooms-selector" onclick="toggleRoomsPopup()">
          <i class="fa fa-bed"></i>
          <span id="rooms-label">1 room, 2 adults</span>
        </div>

        <div class="rooms-popup" id="roomsPopup">
          <div class="rooms-header">
            <h3>ROOMS</h3>
            <div class="room-count">
              <button type="button" onclick="changeRooms(-1)">-</button>
              <span id="room-count">1</span>
              <button type="button" onclick="changeRooms(1)">+</button>
            </div>
          </div>
          <div id="rooms-details"></div>
          <button type="button" onclick="saveRooms()" class="save-btn">SAVE CHANGES</button>
        </div>
      </div>
      
      <div class="selection-container-right">
        <div class="selection-cart">
          <i class="fa fa-shopping-cart"></i>
          <i class="fa fa-angle-down"></i>
        </div>
      </div>
    </div>

    <button type="submit" class="submit-btn">Submit Reservation</button>
  </section>
</form>