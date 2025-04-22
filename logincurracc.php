<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "regtest";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND currentAccount = 'yes'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['email'] = $email;
    header("Location: curraccdash.php");
} else {
    echo "Invalid login credentials or you do not have a current account.";
}

$conn->close();
?>
