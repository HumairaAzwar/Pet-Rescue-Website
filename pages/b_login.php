<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //check for deafult user "ucsc"
        if ($username === 'ucsc' && $password === 'ucsc') {
        // Set session for default user
        $_SESSION['username'] = 'ucsc';
        $_SESSION['role'] = 'ordinary';
        //head to viewpets page
        header('location:viewpets.php');
        exit();
    }
    // Check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];
        $role = $user['role'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Start session and store username and role
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect based on user role
            if ($role=='admin') {
                header('location:adminpage.php'); // Redirect to admin dashboard
            } else {
                header('location:viewpets.php'); // Redirect to view pets for ordinary users
            }
            exit();
        } else {
            $_SESSION['error'] = 'Invalid credentials.';
            header('location:f_login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'User not found.';
        header('location:f_login.php');
        exit();
    }
}
$conn->close();
?>
