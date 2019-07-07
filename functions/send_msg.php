<?php
    include("db.php");
    if(isset($_POST['new_msg']))
    {
        $msg = $_POST['user_msg'];
        $src = $_SESSION['user_id'];
        $dest = $_GET['id'];
        if(isset($_GET['id'])){
            $sql="INSERT INTO msgs(source_id,dest_id,content)
                        VALUES ( '$src' , '$dest','$msg')" ;
            if(!mysqli_query($con,$sql))
                echo mysqli_error($con);
        }

        
    }