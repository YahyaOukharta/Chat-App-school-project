<?php
    session_start();
    if(isset($_SESSION['user_id']))
    {
        header("Location: main.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main Page - Login</title>
</head>
<body>
    <h1>Main Page - Login</h1>

    <div>
        <form action="functions/auth.php" method="POST">
            <div class="error">
                <?php 
                    if(isset($_GET['err']))
                        echo "Username and/or password invalid <br>";
                ?>
            </div>
            <div class="input-group">
                <label for="username">Username</label>
                <input name="username" type="text">
            </div>
            <div class="input-group">
                <label for="pwd">Password</label>
                <input name="pwd" type="password">
            </div>
            <div class="submit-btn">
                <button name="login" type="submit">Login</button>
            </div>
            <p>if you dont have an account, create one <a href="register.php">here</a></p>
        </form>
    </div>
</body>
</html>