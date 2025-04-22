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

// Get the posted values
$id = $_POST['id'];
$purchase_amount = $_POST['purchase_amount'];

// Update the user's balance and complete the purchase
$stmt = $conn->prepare("SELECT currentBalance, coinjar_balance FROM users WHERE id =?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$current_balance = $row['currentBalance'];

if ($current_balance >= $purchase_amount) {
    // Step 1: Calculate the Rounded-Up Amount
    $rounded_up_amount = ceil($purchase_amount); // E.g., $5.75 becomes $6.00
    
    // Step 2: Calculate the Round-Up Amount
    $round_up_amount = $rounded_up_amount - $purchase_amount; // E.g., $6.00 - $5.75 = $0.25

    // Step 3: Update the Current Balance
    $new_balance = $current_balance - $purchase_amount; // E.g., $10.00 - $5.75 = $4.25

    // Update the user's current balance
    $stmt = $conn->prepare("UPDATE users SET currentBalance =? WHERE id =?");
    $stmt->bind_param("di", $new_balance, $id);
    $stmt->execute();

    // Update the coinjar_balance
    $stmt = $conn->prepare("UPDATE users SET coinjar_balance = coinjar_balance +? WHERE id =?");
    $stmt->bind_param("di", $round_up_amount, $id);
    $stmt->execute();

    echo "<h1>Purchase Successful!</h1>";
    echo "<p>Your new balance is: $new_balance</p>";
    echo "<p>You saved $round_up_amount in your coin jar!</p>";
} else {
    echo "<p>Purchase failed. Insufficient balance.</p>";
}

// Close connection
$conn->close();
?>
