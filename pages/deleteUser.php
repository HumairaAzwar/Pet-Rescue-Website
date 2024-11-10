<?php 

include 'db_connect.php';

$id = $_POST['id'];

$statement = $conn->prepare("DELETE FROM users WHERE id = ?");
$statement->bind_param("i",$id);

if ($statement->execute()) {
    echo json_encode(['status' => 'success']);
}
else {
    echo "Error :" . $statement->error; 
}

$statement->close();
$conn->close();

?>