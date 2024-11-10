<html>
<head>
    <title>Help Page</title>
    <link rel="stylesheet" href="style4.css">
    
</head>
<body>

    <?php include 'header.php'; ?>


	<div class="container">
        <h1>We're here to help</h1>

        <!-- Cards Section -->
        <div class="cards">
            <div class="card">
                <div class="icon">👤</div>
                <h3>My account</h3>
                <p><b>Create an Account</b><br>
		 Sign up with your email address to create an account.<br>
		<b>Log In</b><br>
		 Use your credentials to log in and access your dashboard</p>
            </div>

          

            <div class="card">
                <div class="icon">🔍</div>
                <h3>Browse Listings</h3>
                <p>Use the search functionality to find pets available for adoption or fostering.</p>
            </div>

                      

            <div class="card">
                <div class="icon">📝</div>
                <h3>Listing Issues</h3>
                <p> If you encounter problems with listing a pet, ensure all required fields are filled out correctly.</p>
            </div>

           <div class="card">
                <div class="icon">📧</div>
                <h3>Adoption Request Approval</h3>
                <p>Once you submit a pet adoption request, please check your email for approval           updates. We will send all details to your registered email address.</p>
          </div>

           
	     <div class="card">
                <div class="icon">📍</div>
                <h3>Our Main Office</h3>
                <p>123 Main Street, Colombo 03, Sri Lanka.<br>
		 If you need more information you can visit our company.</p>
            </div>

	    <div class="card">
                <div class="icon">☎️</div>
                <h3>Contacts</h3>
                <p>If you need further assistance, please contact our support team:<br>
		Email: pet@support.com<br>
		Phone: +94 7777333221</p>
            </div>

        </div>
    </div>

    <div class="container1">
        
        <div class="form-section">
            <h1>Ask a Question</h1>
            <form action="submit_form.php" method="POST">
                <input type="text" name="name" placeholder="Name" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <textarea name="message" placeholder="Your Question" required></textarea><br>
                <button type="submit">SEND</button>
            </form>
        </div>
   </div>

    <?php include 'footer.php'; ?>
</body>
     
</html>