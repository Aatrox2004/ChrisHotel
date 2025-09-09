<div class="user-container">
  <div class="user-card">
    <h2 class="user-title">User Profile</h2>
    <div class="user-details">
      <p><strong class="user-label">Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
      <p><strong class="user-label">Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong class="user-label">Membership Level:</strong> <?= htmlspecialchars($user['membership']) ?></p>
      <p><strong class="user-label">Last Booking Total:</strong> $<?= htmlspecialchars(number_format($booking['total'], 2)) ?></p>
      <p><strong class="user-label">Last Booking:</strong> <?= htmlspecialchars($booking['checkin'] . ' to ' . $booking['checkout']) ?></p>
    </div>
    <a href="edit_profile.php" class="user-edit-btn">Edit Profile</a>
  </div>
</div>