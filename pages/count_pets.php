<?php
include 'db_connect.php';

$sql = "SELECT COUNT(*) AS total FROM pets";
$result = $conn->query($sql);
# var_dump($result);
# print_r($result);

$total_rows = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    # var_dump($row);
    $total_rows = $row['total'];
}

$conn->close();

echo json_encode(array('total' => $total_rows));
?>
