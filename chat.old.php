z<?php 
    session_start();
    
    include("functions/get_data.php");
    include("functions/send_msg.php");

    //is session expired
    if(time()-$_SESSION['last_use'] > 60 * 3)
    {
        change_user_state($_SESSION['user_id'],"offline");
        session_destroy();
        header("location: index.php");
    }
    else
        $_SESSION['last_use']= time();
    
    if(isset($_GET['logout']))
    { 
        change_user_state($_SESSION['user_id'],"offline");
        session_destroy();
        header("location: index.php");
    }
    if(!isset($_SESSION['user_id']))
          header("location: index.php"); 
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main Page - Chat app </title>
    <link rel="stylesheet" href="style/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    
    <div class="wrapper">
        <div class="menu">
            <h1>Welcome 
                <span class="username">
                    <?php echo get_user_data($_SESSION['user_id'])['username'];?>
                </span>
            </h1>
            <p><a href="?logout=1">Logout</a></p>
        </div>
        <br><br>
        <div class="online_users">
            <strong><p>online users :</p></strong>
            <ul>
                <?php  
                    $users = get_online_users($_SESSION['user_id']);  //only ids
                    foreach ($users as $user) 
                        echo "<li><a href='?id=".$user['id']."'>".$user['username']."</a></li>";
                ?>
            </ul>
        </div>
        <?php if(isset($_GET['id']))
            echo "<p>Chatting with".get_user_data($_GET['id'])['username']."</p>";
        ?>
        <div id="chatbox">
            <?php 
                if(!isset($_GET['id']))
                    echo "/^\\Click on an online user's username to start chatting/^\\";
                else
                {
                    //echo $_GET['id']."<br>".$_SESSION['user_id'];
                    $msgs = get_msgs($_GET['id'],$_SESSION['user_id']);
                    if(!$msgs)
                        echo 'No messages sent yet, type a message in the input box below and press enter or the submit button';
                    else
                        foreach ($msgs as $msg) {
                                $user = get_user_data($msg['source_id']);
                                echo $msg['time']."  ";
                                echo $user['username']."<br>&emsp;";
							
                                if($msg['type'] == "file")//display content
                                {
                                    $file_data = get_file_data($msg['msg_id']);
                                    $name=$file_data['file_name'];
                                    $type=$file_data['file_type'];
                                    $size=$file_data['file_size'];
                                    echo "FILE : ".$name." ,size : ".$size." ,type: ".$type;
                                    echo " //// <a href='uploaded_files/" . $name . "'> CLICK TO DOWNLOAD</a>";
                                    
                                    echo "<br>";
                                }
                                else
                                    echo $msg['content']."<br>";  

                                echo "<br>";
                        }
                }
            ?>
        </div>
        <script>
            var chatbox = document.getElementById('chatbox');
            chatbox.scrollTop = chatbox.scrollHeight;
        </script>
       
        <form method="POST" action="main.php?id=<?php echo $_GET['id'];?>">
            <?php if(isset($_GET['id'])){ ?>
                <p>
                <a href="file_upload.php?id=<?php echo $_GET['id'];?>">Send a file to <?php echo get_user_data($_GET['id'])['username'];?></a>
                </p>
            <?php } ?>
            <input name="user_msg" type="text" id="usermsg">
            <input name="new_msg" type="submit">
        </form>
    </div>

    <?php if(isset($_GET['id'])){ ?>
        <script>// script to reload page everytime there is a new message
            var num = 0; 
            var prev = 0;
            setInterval(function(){
                prev = num;
                $.post("functions/check_updates.php",
                    {   
                        src : "<?php echo $_GET['id'];?>",
                        dest : "<?php echo $_SESSION['user_id'];?>"
                    },
                    function(data,status)
                    {
                        num = parseInt(data);
                        if(num > prev && prev > 0)
                        {
                            //Append new message
                            $.post("functions/check_updates.php",
                            {   
                                src : "<?php echo $_GET['id'];?>",
                                dest : "<?php echo $_SESSION['user_id'];?>",
                                get_last_msg : 1
                            },
                            function(data,status)
                            {
                                $("#chatbox").append(data);
                                chatbox.scrollTop = chatbox.scrollHeight;
                            });
                        }
                    });
            },500);
        </script>
    <?php } ?>
</body>
</html>