<?php
require_once __DIR__ . '/../../Config.php';
require_once __DIR__ . '/../../Utils/View.php';
require_once __DIR__ . '/../../DBConnect.php';
require_once __DIR__ . '/../../Model/Entity/RoomEntity.php';

$rooms = Room::getAvailableRooms();
$rooms = array_map(function($room) {
    return [
        'room_id' => $room->room_id,
        'room_type' => $room->room_type,
        'room_picture' => $room->room_picture,
        'description' => $room->description,
        'size' => $room->size ?? '25',
        'max_occupancy' => $room->max_occupancy ?? '2',
        'bed_type' => $room->bed_type ?? 'Queen Bed',
        'price' => $room->price ?? '150.00'
    ];
}, $rooms);

$content = ob_start();
?>

<section class="hero-banner">
  <div class="hero-text">
    <h1>Rooms & Suites</h1>
    <p>Experience comfort, elegance, and a touch of luxury at Chris Hotel.</p>
  </div>
</section>

<section class="section">
  <h2 class="section-title">Our Rooms</h2>

  <?php if (!empty($rooms)): ?>
    <div class="room-grid">
      <?php foreach ($rooms as $room): ?>
        <div class="room">
          <!-- Room Image -->
          <img src="<?php echo BASE_URL . htmlspecialchars($room['room_picture']); ?>" 
               alt="<?php echo htmlspecialchars($room['room_type']); ?>">

          <div class="room-content">
            <!-- Room Type -->
            <h3 class="room-title"><?php echo htmlspecialchars($room['room_type']); ?></h3>
            
            <!-- Room Description -->
            <p class="room-desc"><?php echo htmlspecialchars($room['description']); ?></p>

            <!-- Room Details -->
            <ul class="room-details">
              <li><i class="fa fa-expand"></i> <?php echo htmlspecialchars($room['size']); ?> SQM</li>
              <li><i class="fa fa-users"></i> Max <?php echo htmlspecialchars($room['max_occupancy']); ?> Guests</li>
              <li><i class="fa fa-bed"></i> <?php echo htmlspecialchars($room['bed_type']); ?></li>
            </ul>

            <!-- Room Price -->
            <p class="room-price">RM <?php echo number_format($room['price'], 2); ?></p>

            <!-- Buttons -->
            <div class="room-buttons">
              <a href="<?php echo BASE_URL; ?>Views/Reservation/Reservation.php?room_id=<?php echo $room['room_id']; ?>" class="btn-book">BOOK NOW</a>
              
              <?php 
              // Determine which details page to link to based on room type
              $detailsPage = '';
              $roomType = strtolower($room['room_type']);
              
              if (strpos($roomType, 'deluxe') !== false) {
                  $detailsPage = 'DeluxeDetails.php';
              } elseif (strpos($roomType, 'standard') !== false) {
                  $detailsPage = 'StandardDetails.php';
              } else {
                  // Default fallback - you might want to create a generic RoomDetails.php
                  $detailsPage = 'DeluxeDetails.php'; // or create a generic one
              }
              ?>
              
              <a href="<?php echo $detailsPage; ?>?id=<?php echo $room['room_id']; ?>" class="btn-read">READ MORE</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>No rooms available right now.</p>
  <?php endif; ?>
</section>