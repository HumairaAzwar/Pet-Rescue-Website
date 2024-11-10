<?php
include 'db_connect.php';

// Fetch adoption requests
$sql = "
    SELECT a.adopter_name, a.adopter_email, a.message, p.name AS pet_name, a.pet_id
    FROM adoption_requests a
    JOIN pets p ON a.pet_id = p.id
";
$result = $conn->query($sql);
?>

<html>
<head>
    <title>View Adoption Requests</title>
    <link rel="stylesheet" href="admin_css.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
       
       h1 {
          padding: 10px;
       }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .approve-button {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve-button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <main>
        <h1>Adoption Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Adopter Name</th>
                    <th>Adopter Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['pet_name']}</td>
                                <td>{$row['adopter_name']}</td>
                                <td>{$row['adopter_email']}</td>
                                <td>{$row['message']}</td>
                                <td>
                                    <form method='POST' action='approveadoptionrequest.php' onsubmit='showAlert(\"Request Approved\")'>
                                        <input type='hidden' name='pet_id' value='{$row['pet_id']}'>
                                        <input type='hidden' name='adopter_email' value='{$row['adopter_email']}'>
                                        <button type='submit' class='approve-button'>Approve</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No adoption requests found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
