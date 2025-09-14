<?php
require_once '../../Config.php';
require_once '../../Utils/View.php';

$content = ob_start();
?>

<main class="room-detail">
  <!-- Title -->
  <section class="room-title-info">
    <h1>Deluxe Room</h1>
    <div class="room-specs">
      <span>35 SQM</span> &bull; <span>2 Adults, 2 Children</span> &bull; <span>King Bed</span>
    </div>
    <p class="room-desc">
      Our Deluxe Room offers a blend of elegance and comfort. Featuring a plush king bed, private balcony with sea views, 
      and upgraded amenities, this room is designed for guests who enjoy extra space and style.
    </p>
  </section>

  <!-- Amenities -->
  <section class="room-amenities">
    <h2>Amenities</h2>
    <ul class="amenities-list">
      <li><i class="fa fa-bed"></i> King Bed</li>
      <li><i class="fa fa-wifi"></i> Free High-Speed Wi-Fi</li>
      <li><i class="fa fa-tv"></i> 42-inch Smart TV</li>
      <li><i class="fa fa-coffee"></i> Coffee Machine & Tea Facilities</li>
      <li><i class="fa fa-bath"></i> Bathtub & Walk-in Shower</li>
      <li><i class="fa fa-sun-o"></i> Private Balcony with Sea View</li>
      <li><i class="fa fa-sliders"></i> Air Conditioning</li>
      <li><i class="fa fa-glass"></i> Mini Bar</li>
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
        <img src="https://themewagon.github.io/sogo/images/img_2.jpg" alt="Standard Room">
        <div class="related-info">
          <h3>Standard Room</h3>
          <p>Queen Bed, City View, Cozy Stay</p>
          <a href="StandardDetails.php" class="btn-small btn-read">Read More</a>
          <a href="<?php echo BASE_URL; ?>Views/Reservation/Reservation.php" class="btn-small btn-book">Book Now</a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
$content = ob_get_clean();
$page_title = 'Deluxe Room - Chris Hotel';
$cssFile = 'Room.css';
require_once '../../Layout.php';
?>