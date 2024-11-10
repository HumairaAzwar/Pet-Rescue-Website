<?php 

include "db_connect.php";

$sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'ordinary'";
$result = $conn->query($sql);

$total_rows = 0;
if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_rows = $row['total'];
}

$conn->close();

echo json_encode(array("total" => $total_rows));
?>