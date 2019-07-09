<?php
    session_start();
    if(isset($_SESSION['user_id']))
    {
        header("Location: chat.php");
    }
?>
<html>
<head>
  <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="inactive underlineHover"><a href="index.php">Sign In</a></h2>
          <h2 class="active">Register</a></h2>
      
          <!-- Login Form -->
          <form action="functions/auth.php" method="POST">
            <div class="error">
              <?php 
                  if(isset($_GET['err'])){
                      if($_GET['err'] == 1)
                          echo "Username and/or email already used.<br>";
                      if($_GET['err'] == 2)
                          echo "Passwords too short or do not match. (3 chars minimum)<br>";
                  }
              ?>
            </div>
            <input type="text" id="login" class="fadeIn second" name="username" placeholder="Login">
            <input type="password" id="password" class="fadeIn third" name="pwd1" placeholder="Password">
            <input type="password" id="password2" class="fadeIn second" name="pwd2" placeholder="Confirm password">
            <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email">

            <input type="submit" name="register" class="fadeIn fourth" value="Register">
          </form>
      
          <!-- Remind Passowrd -->
          <div id="formFooter">
            <a class="underlineHover" href="#">Forgot Password?</a>
          </div>
      
        </div>
      </div>
</body>
</html>