<?php
    include("db.php");
    if(isset($_POST['new_msg']) && !empty($_POST['user_msg']) && !empty($_GET['id']))
    {
        $msg = $_POST['user_msg'];
        $src = $_SESSION['user_id'];
        $dest = $_GET['id'];
        if(isset($_GET['id'])){
            $sql="INSERT INTO msgs(source_id,dest_id,content)
                        VALUES (?,?,?)" ;
            $stmt = mysqli_prepare($con,$sql);
            mysqli_stmt_bind_param($stmt,"sss",$src,$dest,$msg);
            if(!mysqli_stmt_execute($stmt))
                echo mysqli_error($con);
        }   
    }