<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Page </title>
</head>
<body>
    <h1>Register Page </h1>

    <div>
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
            <div class="input-group">
                <label for="username">Username</label>
                <input name="username" type="text">
            </div>
            <div class="input-group">
                <label for="pwd1">Password</label>
                <input name="pwd1" type="password">
            </div>
            <div class="input-group">
                <label for="pwd2">Confirm password</label>
                <input name="pwd2" type="password">
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input name="email" type="email">
            </div>
            <div class="submit-btn">
                <button name ="register" type="submit">Register</button>
            </div>
            <p>if you already have an account, login <a href="index.php">here</a></p>
        </form>
    </div>
</body>
</html>