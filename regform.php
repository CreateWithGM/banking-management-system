<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "regtest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $aadhar = $_POST['aadhar'];
    $pan = $_POST['pan'];
    $voterId = $_POST['voterId'];
    $savingsAccount = $_POST['savingsAccount'];
    $savingsRoundUp = $_POST['savingsRoundUp'];
    $fixedDeposit = $_POST['fixedDeposit'];
    $currentAccount = $_POST['currentAccount'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO users (firstName, middleName, lastName, fatherName, motherName, email, password, mobile, gender, dob, aadhar, pan, voterId, savingsAccount, savingsRoundUp, fixedDeposit, currentAccount)
    VALUES ('$firstName', '$middleName', '$lastName', '$fatherName', '$motherName', '$email', '$password', '$mobile', '$gender', '$dob', '$aadhar', '$pan', '$voterId', '$savingsAccount', '$savingsRoundUp', '$fixedDeposit', '$currentAccount')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
