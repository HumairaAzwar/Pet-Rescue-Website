<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $pet_id = $_POST['pet_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petcare_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert adoption request into database
    $stmt = $conn->prepare("INSERT INTO adoption_requests (pet_id, adopter_name, adopter_email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $pet_id, $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert
                  ('Pet requested for adoption successfully!');
                  window.location.href = 'viewpets.php';
              </script>";
    } else {
        echo "<script>alert('Error submitting the adoption request.');
              window.location.href = 'viewpets.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
