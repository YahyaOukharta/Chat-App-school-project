<?php
session_start();
include("db.php");
include("get_data.php");
//LOGIN 
if(isset($_POST['login']))
{
    print_r($_POST);
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $pwd = mysqli_real_escape_string($con,$_POST['pwd']);

    $pass = md5($pwd); //crypting password using md5 
    
    $sql= "SELECT id FROM user WHERE username = '$username' AND password = '$pass'";
    
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result) == 1){
        //credentials match , login succesful 
        $_SESSION['user_id'] =mysqli_fetch_assoc($result)['id'];
        change_user_state($_SESSION['user_id'],"online");
        $_SESSION['last_use']=time();
        header("location: ../chat.php");
    }
    else 
    {
        echo "username and/or password invalid :(";
        header('location: ../index.php?err=1');
    }
}

//REGISTRATION
if(isset($_POST['register']))
{
    $min_pwd_len = 3; //required length for password 

    $username =mysqli_real_escape_string($con,$_POST['username']);
    $pwd1 =mysqli_real_escape_string($con,$_POST['pwd1']);
    $pwd2 =mysqli_real_escape_string($con,$_POST['pwd2']);
    $email =mysqli_real_escape_string($con,$_POST['email']);

    //check if username or email already exist in database 
    $sql = "SELECT id FROM user WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result) != 0)
        //email or username already exist in database
        header("location: ../register.php?err=1");
    else{
        //check if passwords match
        if($pwd1 != $pwd2 || strlen($pwd1) < $min_pwd_len)
            //passwords do not match or too short
            header("location: ../register.php?err=2");
        else{
            //add user data to db
            $pwd = md5($pwd1); //turn password to md5 
            $sql="INSERT INTO user(username,password,email)
                    VALUES ('$username','$pwd','$email')";
            if(mysqli_query($con,$sql))
                header("Location: ../index.php");
            else
                echo "error : ".mysqli_error($con);
        }
    }
}
