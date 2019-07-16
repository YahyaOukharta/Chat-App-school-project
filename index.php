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
  <title>Se connecter - ChatApp</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="active"> Se connecter </h2>
          <h2 class="inactive underlineHover"><a href="register.php">S'inscrire</a></h2>
      
          <!-- Icon -->
          <div class="fadeIn first" >
            <img src="icon.png" style="width:38%;" id="icon" alt="User Icon" />
          </div>
      
          <!-- Login Form -->
          <form action="functions/auth.php" method="POST">
              <div class="error">
                  <?php 
                      if(isset($_GET['err']))
                          echo "Nom d'utilisateur ou/et mot de passe invalides <br>";
                  ?>
              </div>
            <input type="text" id="login" class="fadeIn second" name="username" placeholder="Nom d'utilisateur">
            <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="Mot de passe">
            <input type="submit" name="login" class="fadeIn fourth" value="Se Connecter">
          </form>
      
          <!-- Remind Passowrd -->
          <div id="formFooter">
            <a class="underlineHover" href="#">Mot de passe oublié?</a>
          </div>
      
        </div>
      </div>
</body>
</html>