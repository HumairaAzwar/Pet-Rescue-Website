<?php 

# echo "running";

include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM pets WHERE id = $id";
$result = $conn->query($sql);

# var_dump($result);

// extracting the data of relevant row using metadata stored in $result variable
$row = $result->fetch_assoc();
# var_dump($row);

$name = $row['name'];
$breed = $row['breed'];
$age = $row['age'];
$description = $row['description'];
$status = $row['status'];

$url = trim('addPets.html?' . http_build_query([
    'name' => $name,
    'breed' => $breed,
    'age' => $age,
    'description' => $description,
    'status' => $status,
    'id' => $id
]));

# var_dump($url);
echo json_encode(array('url' => $url));

$conn->close();
?>