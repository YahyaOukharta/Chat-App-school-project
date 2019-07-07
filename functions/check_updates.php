<?php
    session_start();
    include("db.php");
    include("get_data.php");

    $src = $_POST['src'];
    $dest= $_POST['dest'];

    if(isset($_POST['get_last_msg']))
    {
        $msgs = array();
        array_push($msgs, get_last_msg($src,$dest));
        display_msgs($msgs);
    }
    else {
        $sql="SELECT msg_id from msgs where (source_id ='$src' and dest_id = '$dest');";
        echo mysqli_num_rows(mysqli_query($con,$sql));
    }

