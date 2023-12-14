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

$mobile = $_POST['mobile'];
$user = $_POST['username'];
$pass = $_POST['password'];

// Check if mobile or username already exists
$checkMobile = $conn->prepare("SELECT * FROM users WHERE mobile=?");
$checkMobile->bind_param("s", $mobile);
$checkMobile->execute();
$mobileResult = $checkMobile->get_result();

$checkUser = $conn->prepare("SELECT * FROM users WHERE username=?");
$checkUser->bind_param("s", $user);
$checkUser->execute();
$userResult = $checkUser->get_result();

if ($mobileResult->num_rows > 0) {
    echo "با شماره موبایل شما قبلا اکانتی ساخته شده است. لطفا شماره تماس خود را برسی کنید یا وارد شوید.";
} elseif ($userResult->num_rows > 0) {
    echo "نام کاربری شما تکراری است.";
} else {
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    // Insert user into the database
    $sql = $conn->prepare("INSERT INTO users (mobile, username, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $mobile, $user, $hashed_password);
    if ($sql->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

