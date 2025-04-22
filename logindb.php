<?php
session_start(); // Start the PHP session

// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "regtest"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check if the user exists in the database and password matches
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists and password matches, login successful
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id']; // Store the user's ID in the session variable
        header("Location: indexal.html");
        exit;
    } else {
        // User does not exist or password is incorrect
        echo "Invalid credentials. Please try again.";
    }
}

// Close connection
$conn->close();
?>
