<?php
session_start();

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'regtest';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['id'];
$current_balance = $_SESSION['currentBalance'];
$coinjar_balance = $_SESSION['coinjar_balance'];

// Add coin jar balance to current balance
$new_balance = $current_balance + $coinjar_balance;

// Update user's current balance and reset coin jar balance
$stmt = $conn->prepare("UPDATE users SET currentBalance = ?, coinjar_balance = 0 WHERE id = ?");
$stmt->bind_param("di", $new_balance, $id);
$stmt->execute();

echo "<h1>Balance Transfer Successful!</h1>";
echo "<p>Your new current balance is: $" . $new_balance . "</p>";
echo "<p>Your coin jar balance has been added to your current balance.</p>";

// Close connection
$conn->close();
?>
