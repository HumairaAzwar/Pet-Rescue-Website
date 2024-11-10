<?php 
include "db_connect.php";

# echo "Connected";

$name = $_POST["name"];
$breed = $_POST["breed"];
$age = $_POST["age"];
$description = $_POST["description"];
$status = $_POST["status"];
$id = isset($_POST["primary_key"]) && !empty($_POST["primary_key"]) ? $_POST["primary_key"] : false;

// if id is not null, it means this is an edit
if ($id) {
    var_dump($id);
    // Prepare the UPDATE statement
    $upd_statement = $conn->prepare("UPDATE pets 
                                     SET name = ?, breed = ?, age = ?, description = ?, status = ?
                                     WHERE id = ?");
    $upd_statement->bind_param("ssissi", $name, $breed, $age, $description, $status, $id);

    if ($upd_statement->execute()) {
        // Handle image upload if a new file is uploaded
        $uploadOk = 1;
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $target_dir = "uploads/";
                $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $target_file = $target_dir . $id . "." . $imageFileType;

                // Delete the existing image if it exists
                if (file_exists($target_file)) {
                    unlink($target_file);
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Success
                } else {
                    $uploadOk = 0;
                    echo '<script>
                            alert("There was an error uploading the file.");
                            window.location.href = "addPets.html";
                        </script>';
                    exit();
                }
            } else {
                $uploadOk = 0;
                echo '<script>
                        alert("File is not an image.");
                        window.location.href = "addPets.html";
                    </script>';
                exit();
            }
        }

        if ($uploadOk) {
            echo '<script>
                    alert("Pet details updated successfully!");
                    window.location.href = "addPets.html";
                </script>';
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Error: " . $upd_statement->error;
    }

    $upd_statement->close();
}
else {
    $statement = $conn->prepare("INSERT INTO pets (name, breed, age, description, status) VALUES (?, ?, ?, ?, ?)");
    $statement->bind_param("ssiss", $name, $breed, $age, $description, $status);
    
    // Image handling
    $uploadOk = 1;
    if (isset($_FILES["image"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
    
            $target_dir = "uploads/";
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    
        } else {
            $uploadOk = 0;
            echo '<script>
                    alert("File is not an image.");
                    window.location.href = "addPets.html";
                </script>';
            exit(); // Stop script if file is not an image
        }
    } 
    
    if ($uploadOk && $statement->execute()) {
        echo '<script>
                alert("Pet details added to the database!");
                window.location.href = "addPets.html";
            </script>';
    } else {
        echo "Error: " . $statement->error;
        exit();
    }
    
    
    // extract the real primary key
    $primaryKey = $conn->insert_id;
    
    // Generate a unique file name using the primary key
    $target_file = $target_dir . $primaryKey . "." . $imageFileType;
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $uploadOk = 1;
        $image = $primaryKey . "." . $imageFileType; // To DB if NEEDED !!!

        $sql = "UPDATE pets SET image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $image, $primaryKey);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        $uploadOk = 0;
        echo '<script>
                alert("There was an error uploading the file.");
                window.location.href = "addPets.html";
            </script>';
        exit(); // Stop script if file upload fails
    }
    
    $statement->close();
    $conn->close();

}


?>
