// addmoney.php
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

$id = $_POST['id'];
$add_money = floatval($_POST['add_money']); // Use floatval to convert to decimal value

// Update user's current balance
$stmt = $conn->prepare("UPDATE users SET currentBalance = currentBalance + ? WHERE id = ?");
$stmt->bind_param("di", $add_money, $id);
$stmt->execute();

// Display transaction success message
echo "<h1>Transaction Success!</h1>";
echo "<p>Amount of $add_money has been added to your account.</p>";

// Add link to go to transaction page
echo "<p><a href='curraccdash.php'>Go to Transaction Page</a></p>";

// Close connection
$conn->close();

exit;
?>