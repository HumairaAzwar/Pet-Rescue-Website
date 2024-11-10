<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
} else {
    $error = '';
}
unset($_SESSION['error']);
?>

<?php include 'header.php'; ?>

<div class="login-container">
    <h2>Login</h2>
    <form action="b_login.php" method="POST">
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="signup-link">
        <p>Don't have an account? <a href="f_signup.php">Sign up here</a>.</p>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
