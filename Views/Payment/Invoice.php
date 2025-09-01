<?php
require_once "../../Ultis/SecurityUtils.php";
secure_session_start();

// Privilege check: must have invoice after successful payment
if (!isset($_SESSION['invoice'])) {
    header("Location: Checkout.php");
    exit("Unauthorized access: No invoice found.");
}

$invoice = $_SESSION['invoice'];
?>
<h2>Invoice</h2>
<p><strong>Invoice ID:</strong> <?= htmlspecialchars($invoice['invoice_id']) ?></p>
<p><strong>Reservation ID:</strong> <?= htmlspecialchars($invoice['reservation_id']) ?></p>
<p><strong>Amount Paid:</strong> $<?= htmlspecialchars($invoice['amount']) ?></p>
<p><strong>Payment Gateway:</strong> <?= htmlspecialchars($invoice['gateway']) ?></p>
<p><strong>Date:</strong> <?= htmlspecialchars($invoice['date']) ?></p>
