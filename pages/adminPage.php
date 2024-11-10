<html>
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="./adminPage.css" /> 
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div id="Container">
            <div id="Tabs">
                <ul>
                    <li><a href="./Dashbord.html" target="display">Dashboard</a></li>
                    <li><a href="./users.html" target="display">Users</a></li>
                    <li><a href="./pets.html" target="display">Pets</a></li>
                    <li><a href="./addUser.html" target="display">Add User</a></li>
                    <li><a href="./addPets.html" target="display">Add Pets</a></li>
                    <li><a href="viewadoptionrequest.php" target="display">Adoption Requests</a></li>
                    <li><a href="feedback.php" target="display">Customer Feedbacks</a></li>

                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </div>
                <iframe src="./Dashbord.html" name="display">
                </iframe>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>