<html>
<head>
    <title>Admin Feedback Page</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
       h1{
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


    </style>
</head>
<body>
    <h1>Help Form Submissions</h1>

        
    <?php 
    include "db_connect.php";

    // Query to retrieve feedback from the 'submissions' table
    $sql = "SELECT name, email, message FROM submissions";
    $result = $conn->query($sql);

    if ($result === FALSE) {
        die("Error: " . $conn->error);
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Feedback</th>
                <th>Mark</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row["message"])) . "</td>";
                    echo "<td><input type='checkbox' name='marked[]' value='" . $row["email"] . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback found.</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>