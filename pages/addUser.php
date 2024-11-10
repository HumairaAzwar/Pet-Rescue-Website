<?php 

include "db_connect.php";

$username = $_POST["username"];
$password = $_POST["password"];
$role = $_POST["role"];

$hashed_password = password_hash("mypassword", PASSWORD_DEFAULT);

$statement = $conn->prepare("INSERT INTO users (username,password,role) VALUES (?,?,?)");
$statement->bind_param("sss",$username,$hashed_password,$role);

if ($statement->execute()) {
    echo '<script>
            alert("User was added to the database successfully");
            window.location.href = "addUser.html";
        </script>';
}
else {
    echo "Error: ". $statement->error;
}

$statement->close();
$conn->close();
?>