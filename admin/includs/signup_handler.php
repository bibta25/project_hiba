<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'machtala';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$errors = [];

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $errors[] = "All fields are required.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

$check_query = "SELECT * FROM users WHERE email='$email' OR username='$username'";
$result = $conn->query($check_query);
if ($result->num_rows > 0) {
    $errors[] = "Email or Username already exists.";
}

if (empty($errors)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location.href='loginM.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}

$conn->close();
?>
