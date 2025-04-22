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
$mobile = $_POST['phone']; // Change to 'mobile' column
$password = $_POST['password'];

// Check login credentials
$stmt = $conn->prepare("SELECT id, currentBalance, coinjar_balance FROM users WHERE mobile = ? AND password = ?");
$stmt->bind_param("ss", $mobile, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];
    $_SESSION['currentBalance'] = $row['currentBalance'];
    $_SESSION['coinjar_balance'] = $row['coinjar_balance'];

    echo "<h1>Welcome to Your Coin Jar Account</h1>";
    echo "<p>Coin Jar Balance: $" . $row['coinjar_balance'] . "</p>";
    echo "<form action='addcjtocurr.php' method='post'>
            <button type='submit'>Add Coin Jar Balance to Current Balance</button>
          </form>";
} else {
    echo "<p>Invalid mobile number or password. Please try again.</p>";
}

// Close connection
$conn->close();
?>
