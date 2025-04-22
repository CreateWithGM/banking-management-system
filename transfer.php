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
    $id = $_POST['id'];
    $receiver_id = $_POST['receiver_id'];
    $receiver_phone = $_POST['receiver_phone'];
    $transfer_amount = floatval($_POST['transfer_amount']); // Convert to float value

    // Check if receiver exists
    $stmt = $conn->prepare("SELECT id, mobile, currentBalance FROM users WHERE id =? OR mobile =?");
    $stmt->bind_param("is", $receiver_id, $receiver_phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Receiver exists, get their current balance
        $row = $result->fetch_assoc();
        $receiver_current_balance = $row['currentBalance'];

        // Check if sender has sufficient balance
        $stmt = $conn->prepare("SELECT currentBalance FROM users WHERE id =?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $sender_current_balance = $row['currentBalance'];

        if ($sender_current_balance >= $transfer_amount) {
            // Transfer amount
            $new_sender_balance = $sender_current_balance - $transfer_amount;
            $new_receiver_balance = $receiver_current_balance + $transfer_amount;

            $stmt = $conn->prepare("UPDATE users SET currentBalance =? WHERE id =?");
            $stmt->bind_param("dd", $new_sender_balance, $id);
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE users SET currentBalance =? WHERE id =?");
            $stmt->bind_param("dd", $new_receiver_balance, $receiver_id);
            $stmt->execute();

            echo "<h1>Transfer Successful!</h1>";
            echo "<p>Amount of $transfer_amount has been transferred to $receiver_phone.</p>";
            echo "<p><a href='curraccdash.php'>Go to Transaction Page</a></p>";
        } else {
            echo "<h1>Insufficient Balance</h1>";
            echo "<p>You do not have sufficient balance to transfer $transfer_amount.</p>";
            echo "<p><a href='curraccdash.php'>Go to Transaction Page</a></p>";
        }
    } else {
        echo "<h1>Receiver Not Found</h1>";
        echo "<p>The receiver with ID $receiver_id or phone number $receiver_phone was not found.</p>";
        echo "<p><a href='curraccdash.php'>Go to Transaction Page</a></p>";
    }
}

// Close connection
$conn->close();

?>