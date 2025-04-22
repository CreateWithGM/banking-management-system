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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get posted data
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Query to check login credentials
    $stmt = $conn->prepare("SELECT id, mobile, currentBalance FROM users WHERE mobile =? AND password =?");
    $stmt->bind_param("ss", $phone, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful, get id, mobile, and current balance
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $mobile = $row['mobile'];
        $current_balance = $row['currentBalance'];

        // Store user's ID in session variable
        $_SESSION['id'] = $id;

        // Display logged in mobile number, id, and current balance
        echo "<h1>Welcome, $mobile!</h1>";
        echo "<p>Your ID is: $id</p>";
        echo "<p>Your current balance is: $current_balance</p>";

        // Add money to current balance form
        echo "<form action='addmoney.php' method='post'>";
        echo "<label for='add_money'>Add money to your current balance:</label>";
        echo "<input type='number' id='add_money' name='add_money' step='0.01'>";
        echo "<button type='submit'>Add Money</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";

        // Transfer amount to another account form
        echo "<h2>Transfer Amount to Another Account</h2>";
        echo "<form action='transfer.php' method='post'>";
        echo "<label for='receiver_id'>Receiver's ID:</label>";
        echo "<input type='number' id='receiver_id' name='receiver_id'>";
        echo "<br>";
        echo "<label for='receiver_phone'>Receiver's Phone Number:</label>";
        echo "<input type='tel' id='receiver_phone' name='receiver_phone'>";
        echo "<br>";
        echo "<label for='transfer_amount'>Enter Amount to Transfer:</label>";
        echo "<input type='number' id='transfer_amount' name='transfer_amount'>";
        echo "<br>";
        echo "<button type='submit'>Transfer Amount</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";

        // Purchase product form
        echo "<h2>Purchase Product</h2>";
        echo "<form action='purchase.php' method='post'>";
        echo "<button type='submit'>Purchase Product</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";
    } else {
        echo "<h1>Invalid login credentials</h1>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if user is logged in
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $stmt = $conn->prepare("SELECT mobile, currentBalance FROM users WHERE id =?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $mobile = $row['mobile'];
        $current_balance = $row['currentBalance'];

        // Display logged in mobile number, id, and current balance
        echo "<h1>Welcome, $mobile!</h1>";
        echo "<p>Your ID is: $id</p>";
        echo "<p>Your current balance is: $current_balance</p>";

        // Add money to current balance form
        echo "<form action='addmoney.php' method='post'>";
        echo "<label for='add_money'>Add money to your current balance:</label>";
        echo "<input type='number' id='add_money' name='add_money'>";
        echo "<button type='submit'>Add Money</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";

        // Transfer amount to another account form
        echo "<h2>Transfer Amount to Another Account</h2>";
        echo "<form action='transfer.php' method='post'>";
        echo "<label for='receiver_id'>Receiver's ID:</label>";
        echo "<input type='number' id='receiver_id' name='receiver_id'>";
        echo "<br>";
        echo "<label for='receiver_phone'>Receiver's Phone Number:</label>";
        echo "<input type='tel' id='receiver_phone' name='receiver_phone'>";
        echo "<br>";
        echo "<label for='transfer_amount'>Enter Amount to Transfer:</label>";
        echo "<input type='number' id='transfer_amount' name='transfer_amount'>";
        echo "<br>";
        echo "<button type='submit'>Transfer Amount</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";

        // Purchase product form
        echo "<h2>Purchase Product</h2>";
        echo "<form action='purchase.php' method='post'>";
        echo "<button type='submit'>Purchase Product</button>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "</form>";
    } else {
        echo "<h1>You are not logged in</h1>";
    }
}

// Close connection
$conn->close();
?>