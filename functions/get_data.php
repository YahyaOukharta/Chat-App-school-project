<?php

    function get_user_data($id)
    {
        include("db.php");
        $sql = "SELECT * FROM user WHERE id = '$id'";
        return mysqli_fetch_assoc(mysqli_query($con,$sql));
    }

    function get_msgs($src, $dest)
    {
        $data = array();
        include("db.php");
        $sql ="SELECT * FROM msgs where (source_id = '$src' and dest_id ='$dest') 
                    OR (source_id = '$dest' and dest_id ='$src')";
        $result =  mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $row['time'] = date("H:i", strtotime($row['time']));
            array_push($data, $row);
        }
        return $data;
    }

    function get_online_users($id)
    {
        $users = array();
        include("db.php");
        $sql ="SELECT id,username FROM user WHERE (NOT id = '$id') AND state = 'online' ; ";
        $result =  mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($users, $row);
        }
        return $users;
    }

    function change_user_state($id,$state) //online or offline
    {
        include("db.php");
        $sql = "UPDATE user SET state = '$state' WHERE id = '$id';";
        if(!mysqli_query($con,$sql))
            echo mysqli_error($con);
    }

    function get_file_data($msg_id) //get details about a file from a msg_id
    {
        include("db.php");
        $sql = "SELECT * from files where msg_id = '$msg_id';";
        return mysqli_fetch_assoc(mysqli_query($con,$sql));
    }

    function display_msgs($msgs)
    {
        foreach($msgs as $msg)
        {
            $user_id = get_user_data($msg['source_id'])['id'];
            $content = "";
            if($msg['type'] == "file")
            {
                $file_data = get_file_data($msg['msg_id']);
                $name=$file_data['file_name'];
                $type=$file_data['file_type'];
                $size=$file_data['file_size'];
                $content = "FICHIER : ".$name." | Taille : ".($size/1000)." kb | Type: ".$type." ||| <a href='uploaded_files/" . $name . "' style='text-decoration:none;color:#FFB12E;'> Cliquez pour telecharger le fichier  </a>";          
                if(strstr($type,"image"))
                    $content=$content."<img src='uploaded_files/" . $name ."'>";
            }
            else 
                $content = $msg['content'];
            if($user_id == $_SESSION['user_id'])
            {
                echo "<div class='outgoing_msg'>
                <div class='sent_msg'>
                <p>".$content."</p> 
                <span class='time_date'>".$msg['time']."</span> </div>
                </div>";
            }
            else
            {
                echo "<div class='incoming_msg'>
                <div class='received_msg'>
                  <div class='received_withd_msg'>
                    <p>".$content."</p>
                    <span class='time_date'>".$msg['time']."</span></div>
                </div>
              </div>";
            }
        }
    }

    function display_online_users($users)
    {
        foreach ($users as $user) {
            $chat_state="";
            $last_msg= get_last_msg($user['id'],$_SESSION['user_id']);

            if(isset($_GET['id']) && $user['id']==$_GET['id'])
                $chat_state="active_chat";
            if(!isset($last_msg['content']))
            {      
                $last_msg['content']="";
                $last_msg['time']="";
            }           
             echo"<div class='chat_list ".$chat_state."'>
                <a href='?id=".$user['id']."'>
                <div class='chat_people'>
                <div class='chat_img'> <img src='https://ptetutorials.com/images/user-profile.png' alt='".$user['username']."'> </div>
                <div class='chat_ib '>
                <h5>".$user['username']."<span class='chat_date'>".$last_msg['time']."</span></h5>
                <p>".$last_msg['content']."</p>
                </div>
                </div>
                </a>
                </div>";
        }
        
    }

    function get_last_msg($src, $dest)
    {
        include("db.php");
        $sql="SELECT * from msgs where (source_id ='$src' and dest_id = '$dest')
                ORDER BY time DESC LIMIT 1;";
        $msg = mysqli_fetch_assoc(mysqli_query($con,$sql));
        $msg['time'] = date("H:i", strtotime($msg['time']));
        return $msg;
    }