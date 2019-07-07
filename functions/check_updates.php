<?php
    include("db.php");
    include("get_data.php");

    $src = $_POST['src'];
    $dest= $_POST['dest'];

    if(isset($_POST['get_last_msg']))
    {
        $sql="SELECT * from msgs where (source_id ='$src' and dest_id = '$dest')
                ORDER BY time DESC LIMIT 1;";
        $msg = mysqli_fetch_assoc(mysqli_query($con,$sql));
        $user = get_user_data($msg['source_id']);
        echo date("H:i", strtotime($msg['time']))."  ";
        echo $user['username']."<br>&emsp;";
        echo $msg['content']."<br>"; 
    }
    else {
        $sql="SELECT msg_id from msgs where (source_id ='$src' and dest_id = '$dest');";
        echo mysqli_num_rows(mysqli_query($con,$sql));
    }

