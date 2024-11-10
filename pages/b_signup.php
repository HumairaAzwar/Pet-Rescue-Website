<?php
include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $role = 'ordinary'; // Automatically set user role to 'ordinary'

    // Passwords don't match
    if($password !== $confirm_pass){
        $_SESSION['error'] = 'Passwords do not match';
        header('location:f_signup.php');
        exit();
    }

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $_SESSION['error'] = 'Username already taken.';
        header('location:f_signup.php');
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";

        if($conn->query($query) === TRUE){
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role; // Store role in session
            header('location:viewpets.php'); // Redirect to viewpets for ordinary users
            exit();
        } else {
            $_SESSION['error'] = 'Error in creating account. Please try again later.';
            header('location:f_signup.php');
            exit();
        }
    }
}
$conn->close();
?>
