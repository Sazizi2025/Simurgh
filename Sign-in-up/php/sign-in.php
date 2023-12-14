<?php
$server = "server_name";
$username = "db_username";
$password = "db_password";
$dbname = "db_name";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'];
$pass = $_POST['password'];

// Check user in the database
$sql = $conn->prepare("SELECT * FROM users WHERE username=?");
$sql->bind_param("s", $user);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        echo "User logged in successfully";
    } else {
        echo "نام کاربری یا رمز عبور اشتباه است. در صورتی که هنوز اکانتی ندارید، اکانت جدیدی بسازید.";
    }
} else {
    echo "نام کاربری یا رمز عبور اشتباه است. در صورتی که هنوز اکانتی ندارید، اکانت جدیدی بسازید.";
}

$conn->close();
?>

