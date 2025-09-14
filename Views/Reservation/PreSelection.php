<section class="pre-selection-section">
    <h2>Select Your Stay Details</h2>
    <div class="form-group">
        <label for="date-range">Select Dates:</label>
        <input type="text" class="date-range" id="date-range" readonly placeholder="Check-in → Check-out">
        <input type="hidden" id="reservation-checkin" name="checkin">
        <input type="hidden" id="reservation-checkout" name="checkout">
    </div>
    <div class="rooms-selector">
        <label for="rooms-label">Guests:</label>
        <div class="rooms-selector-container" onclick="toggleRoomsPopup()">
            <i class="fa fa-bed"></i>
            <span id="rooms-label" class="rooms-label">2 Adults, 0 Children</span>
        </div>
        <div class="rooms-popup" id="roomsPopup">
            <div class="rooms-header">
                <h3>GUESTS</h3>
            </div>
            <div id="rooms-details" class="rooms-details"></div>
            <p class="accommodate-error" style="display: none; color: red;">Total guests cannot exceed 5</p>
            <button type="button" onclick="saveGuests()" class="save-btn">SAVE CHANGES</button>
        </div>
    </div>
    <div class="calendar-container" id="calendarContainer">
        <div class="calendar-header">
            <button type="button" onclick="prevMonth()" class="prev-button">&#10094;</button>
            <span id="calendarTitle"></span>
            <button type="button" onclick="nextMonth()" class="next-button">&#10095;</button>
        </div>
        <div id="calendar-body" class="calendar-body"></div>
    </div>
    <button type="button" onclick="validateAndProceed()" class="proceed-btn">Proceed to Reservation</button>
</section>
<script src="<?php echo BASE_URL; ?>assets/js/<?php echo $data['jsFile']; ?>"></script>
<script>
    const BASE_URL = '<?php echo rtrim(BASE_URL, "/") . "/"; ?>';
</script>