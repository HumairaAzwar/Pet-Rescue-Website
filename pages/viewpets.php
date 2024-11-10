<?php
session_start(); 

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the current user's username from the session
} else {
    // If not logged in, redirect to login page (optional)
    header("Location: login.php");
    exit();
}
?>


<html>
<head>
    <title>View Pets</title>
    <link rel="stylesheet" href="home_css.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        main {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
        }

        .pet-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .pet-item {
            background-color: #FFF7E1;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 450px;
        }

        .pet-item img {
            width: 100%;
            max-width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        #pet-search {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        #pet-search form {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        #pet-search input {
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #pet-search button {
            padding: 10px 20px;
            background-color: #ee844b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #pet-search button:hover {
            background-color: #D2B48C;
        }

        .adopt-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .available {
            background-color: #28a745;
            color: white;
        }

        .unavailable {
            background-color: #6c757d;
            color: white;
        }

        #adopt-form-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        #adopt-form-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #adopt-form-content h2 {
            margin-top: 0;
        }

        #adopt-form-content label, #adopt-form-content input, #adopt-form-content textarea {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        #adopt-form-content input, #adopt-form-content textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #adopt-form-content button {
            padding: 10px 20px;
            background-color: #ee844b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #adopt-form-content button:hover {
            background-color: #D2B48C;
        }

        .greeting {
        text-align: justify;
        margin-left: 20px;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <h1 class="greeting">Hello! <?php echo htmlspecialchars($username); ?></h1>

    <!-- Main Section -->
    <main>
        <section id="pet-search">
            <h2>Search Pets</h2>
            <form method="GET" action="viewpets.php">
                <input type="text" name="query" placeholder="Search for a Pet..." value="<?php echo htmlspecialchars($_GET['query'] ?? '', ENT_QUOTES); ?>">
                <button type="submit">Search</button>
            </form>
        </section>

        <section id="pet-items">
            <h2>Our Pets</h2>
            <div id="pet-results" class="pet-section">
                <?php
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    include 'db_connect.php';

                    // SQL query to fetch pets
                    $sql = "SELECT * FROM pets WHERE 1"; // query to fetch all pets

                    if (isset($_GET['query']) && !empty($_GET['query'])) {
                        $query = $_GET['query'];
                        $searchTerm = "%" . $query . "%";
                        $sql = "SELECT * FROM pets WHERE name LIKE ? OR description LIKE ? OR breed LIKE ?";
                    }

                    // Prepare and execute the SQL query
                    if ($stmt = $conn->prepare($sql)) {
                        if (isset($searchTerm)) {
                            $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
                        }
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $result = $conn->query($sql); // in case of prepare failure
                    }

                    // Display pet items
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imageUrl = 'uploads/' . $row['image'];
                            $status = strtolower($row['status']);
                            $buttonClass = ($status == 'available') ? 'available' : 'unavailable';
                            $buttonText = ($status == 'available') ? 'Request to Adopt' : 'Rehomed';
                            $buttonDisabled = ($status == 'available') ? '' : 'disabled';

                            echo "<div class='pet-item'>
                                    <h3>{$row['name']}</h3>
                                    <img src='{$imageUrl}' alt='{$row['name']}'>
                                    <p>Breed: {$row['breed']}</p>
                                    <p>Age: {$row['age']} years</p>
                                    <p>{$row['description']}</p>
                                    <button class='adopt-button $buttonClass' $buttonDisabled onclick='showAdoptForm({$row['id']})'>$buttonText</button>
                                  </div>";
                        }
                    } else {
                        echo "<p>No pets found.</p>";
                    }

                    // Close connection
                    $conn->close();
                ?>
            </div>
        </section>

        <!-- form for adoption request -->
        <div id="adopt-form-modal">
            <div id="adopt-form-content">
                <h2>Request to Adopt</h2>
                <form method="POST" action="adopt.php">
                    <input type="hidden" name="pet_id" id="pet_id">
                    <label for="name">Your Name:</label>
                    <input type="text" name="name" id="name" required>
                    <label for="email">Your Email:</label>
                    <input type="email" name="email" id="email" required>
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" required></textarea>
                    <button type="submit">Submit Request</button>
                </form>
            </div>
        </div>

        <script>
            function showAdoptForm(petId) {
                document.getElementById("adopt-form-modal").style.display = "block";
                document.getElementById("pet_id").value = petId;
            }

            window.onclick = function(event) {
                var modal = document.getElementById("adopt-form-modal");
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
