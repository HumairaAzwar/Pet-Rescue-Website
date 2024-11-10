<?php
session_start();
if(isset($_SESSION['error'])) {
    $error=$_SESSION['error'];
}else{
    $error='';
}
unset($_SESSION['error']);
?>
<?php include 'header.php'; ?>
         <div class="signup-container">
            <h2>Sign Up</h2>
            <form id="signupForm" action="b_signup.php" method="POST">
                <!--display the error message-->
                <div class="error">
                <?php
                    if(!empty($error)) echo htmlspecialchars($error);
                ?>
                </div>
                <input type="text" name="username"  placeholder="Username" required>
                <input type="password" name="password" id="pass" placeholder="Password" required>
                <input type="password" name="confirm_password"  id="confPass" placeholder="confirm password" required>
                <div id="msg"></div>
                <button type="submit">Sign Up</button>
                <div class="login-link">
                <p>Already have an account? <a href="f_login.php">Login here</a>.</p>
            </div>
            </form>
            <script language="javascript">


                document.getElementById('signupForm').addEventListener('submit',function(event){
                    if (!checkPass()){
                        event.preventDefault();
                    }
                });

                document.getElementById('pass').addEventListener('input',checkPass);
                document.getElementById('confPass').addEventListener('input',checkPass);


                function checkPass(){
                const password=document.getElementById('pass').value;
                const confPassword=document.getElementById('confPass').value;
                const message=document.getElementById('msg');

                if(password.length<8){
                    message.textContent="Password must be at least 8 characters."
                    message.style.color="red";
                    return false;
                }

                if( confPassword && password ===  confPassword){
                    message.textContent="Passwords match!";
                    message.style.color="green";
                    return true;

                }else if( confPassword && password !==  confPassword){
                    message.textContent="Passwords do not match!";
                    message.style.color="red";
                    return false;
                    }
                
                message.textContent = "";
                return true;
    
                }

            </script>
        </div>

<?php include 'footer.php'; ?>