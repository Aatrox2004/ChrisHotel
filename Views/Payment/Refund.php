<?php
require_once "../../Ultis/SecurityUtils.php";
secure_session_start();

// Privilege check: only if invoice exists
if (!isset($_SESSION['invoice'])) {
    header("Location: Invoice.php");
    exit("Unauthorized access: Refund only available for valid invoices.");
}
?>
<h2>Refund Request</h2>
<form action="../../Controller/PaymentControl.php" method="POST">
  <input type="hidden" name="action" value="refund">
  <label for="invoice_id">Invoice ID:</label>
  <input type="text" name="invoice_id" value="<?= htmlspecialchars($_SESSION['invoice']['invoice_id']) ?>" readonly><br><br>
  <button type="submit">Process Refund</button>
</form>
<?php
require_once "../../Ultis/SecurityUtils.php";
secure_session_start();

// Privilege check: only if invoice exists
if (!isset($_SESSION['invoice'])) {
    header("Location: Invoice.php");
    exit("Unauthorized access: Refund only available for valid invoices.");
}
?>
<h2>Refund Request</h2>
<form action="../../Controller/PaymentControl.php" method="POST">
  <input type="hidden" name="action" value="refund">
  <label for="invoice_id">Invoice ID:</label>
  <input type="text" name="invoice_id" value="<?= htmlspecialchars($_SESSION['invoice']['invoice_id']) ?>" readonly><br><br>
  <button type="submit">Process Refund</button>
</form>
