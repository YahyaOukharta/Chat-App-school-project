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
  <title>S'insrire - ChatApp</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="inactive underlineHover"><a href="index.php">Se Connecter</a></h2>
          <h2 class="active">S'inscrire</a></h2>
      
          <!-- Login Form -->
          <form action="functions/auth.php" method="POST">
            <div class="error">
              <?php 
                  if(isset($_GET['err'])){
                      if($_GET['err'] == 1)
                          echo "Nom d'utilisateur ou/et email deja utilisés.<br>";
                      if($_GET['err'] == 2)
                          echo "Mots de passe trop court ou bien sont differents. (3 chars minimum)<br>";
                  }
              ?>
            </div>
            <input type="text" id="login" class="fadeIn second" name="username" placeholder="Nom d'utilisateur">
            <input type="password" id="password" class="fadeIn third" name="pwd1" placeholder="Mot de passe">
            <input type="password" id="password2" class="fadeIn second" name="pwd2" placeholder="Confirmez le mot de passe">
            <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email">

            <input type="submit" name="register" class="fadeIn fourth" value="S'inscrire">
          </form>
      
          <!-- Remind Passowrd -->
          <div id="formFooter">
            <a class="underlineHover" href="#">Un probleme? Contactez nous!</a>
          </div>
      
        </div>
      </div>
</body>
</html>