<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // If not logged in, redirect to the login page
    header("Location: curracclogin.html");
    exit();
}

// Display the logged-in user's mobile number and current balance
$mobile = $_SESSION['mobile'];
$currentBalance = $_SESSION['currentBalance'];

// HTML content for the dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .user-info {
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <div class="user-info">
            <p><strong>Mobile Number:</strong> <?php echo $mobile; ?></p>
            <p><strong>Current Balance:</strong> $<?php echo $currentBalance; ?></p>
            <!-- Display other user details if needed -->
        </div>
        <!-- <a href="logout.php">Logout</a> Link to logout.php for logging out -->
    </div>
</body>
</html>
