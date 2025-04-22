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
    die("Connection failed: ". $conn->connect_error);
}

// Generate a random amount between 100 and 10000.00
$amount = rand(100, 10000) + (rand(0, 99) / 100);

// Display the amount to be paid
echo "<h1>Purchase Product</h1>";
echo "<p>To purchase this product, you must pay: $amount</p>";

// Check if the user has sufficient balance
$id = $_POST['id'];
$stmt = $conn->prepare("SELECT currentBalance FROM users WHERE id =?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$current_balance = $row['currentBalance'];

if ($current_balance >= $amount) {
    echo "<p>You have sufficient balance to purchase this product. Your current balance is: $current_balance</p>";
    // Form to enter amount to purchase
    echo "<form action='success.php' method='post'>";
    echo "<label for='purchase_amount'>Enter amount to purchase:</label>";
    echo "<input type='number' id='purchase_amount' name='purchase_amount' step='0.01' value='$amount'>";
    echo "<br>";
    echo "<button type='submit'>Pay to Purchase</button>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='hidden' name='amount' value='$amount'>";
    echo "</form>";
} else {
    echo "<p>You do not have sufficient balance to purchase this product. Your current balance is: $current_balance</p>";
}

// Close connection
$conn->close();
?>