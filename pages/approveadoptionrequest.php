<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';


if (isset($_POST['pet_id']) && isset($_POST['adopter_email'])) {
    $pet_id = $_POST['pet_id'];
    $adopter_email = $_POST['adopter_email'];

    // Update the status of the pet in the pets table 
    $updatePetSql = "UPDATE pets SET status = 'rehomed' WHERE id = ?";
    $stmt = $conn->prepare($updatePetSql);
    $stmt->bind_param('i', $pet_id);
    $stmt->execute();

    // Delete the adoption request from the adoption_request table
    $deleteRequestSql = "DELETE FROM adoption_requests WHERE pet_id = ? AND adopter_email = ?";
    $stmt = $conn->prepare($deleteRequestSql);
    $stmt->bind_param('is', $pet_id, $adopter_email);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Redirect to the view adoption requests page
    header("Location: viewadoptionrequest.php");
    exit();
} else {
    // Redirect if parameters are not set
    header("Location: viewadoptionrequest.php");
    exit();
}
?>
