<?php
require_once '../../Config.php';
require_once '../../Utils/View.php';

$content = ob_start();
?>

<main class="room-detail">
  <!-- Title -->
  <section class="room-title-info">
    <h1>Standard Room</h1>
    <div class="room-specs">
      <span>25 SQM</span> &bull; <span>2 Adults, 1 Child</span> &bull; <span>Queen Bed</span>
    </div>
    <p class="room-desc">
      Perfect for leisure or business travelers, our Standard Room offers modern comfort at an affordable price. 
      Enjoy a cozy queen bed, complimentary Wi-Fi, and city views, along with all the essentials for a relaxing stay.
    </p>
  </section>

  <!-- Amenities -->
  <section class="room-amenities">
    <h2>Amenities</h2>
    <ul class="amenities-list">
      <li><i class="fa fa-bed"></i> Queen Bed</li>
      <li><i class="fa fa-wifi"></i> Free High-Speed Wi-Fi</li>
      <li><i class="fa fa-tv"></i> Flat Screen TV</li>
      <li><i class="fa fa-coffee"></i> Coffee & Tea Facilities</li>
      <li><i class="fa fa-shower"></i> Walk-in Shower</li>
      <li><i class="fa fa-phone"></i> In-room Telephone</li>
      <li><i class="fa fa-sliders"></i> Air Conditioning</li>
      <li><i class="fa fa-lock"></i> Safety Deposit Box</li>
    </ul>
  </section>

  <!-- Buttons -->
  <section class="room-buttons">
    <a href="<?php echo BASE_URL; ?>Views/Reservation/Reservation.php" class="btn btn-book">Book Now</a>
    <a href="<?php echo BASE_URL; ?>Views/Room/Rooms.php" class="btn btn-back">Back to Rooms</a>
  </section>

  <!-- Related Rooms -->
  <section class="related-rooms">
    <h2>You May Also Like</h2>
    <div class="related-grid">
      <div class="related-card">
        <img src="https://themewagon.github.io/sogo/images/img_1.jpg" alt="Deluxe Room">
        <div class="related-info">
          <h3>Deluxe Room</h3>
          <p>King Bed, Sea View, Spacious Comfort</p>
          <a href="DeluxeDetails.php" class="btn-small btn-read">Read More</a>
          <a href="<?php echo BASE_URL; ?>Views/Reservation/Reservation.php" class="btn-small btn-book">Book Now</a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
$content = ob_get_clean();
$page_title = 'Standard Room - Chris Hotel';
$cssFile = 'Room.css';
require_once '../../Layout.php';
?>