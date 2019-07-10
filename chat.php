<?php 
    session_start();
    
    include("functions/get_data.php");
    include("functions/send_msg.php");

    //is session expired
    if(time()-$_SESSION['last_use'] > 60 * 40)
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
 
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="style/chat.css">
</head>
<body>
<div class="container">
  <div class="messaging">
    <div class="inbox_msg">
      <div class="inbox_people">
        <div class="headind_srch">
                <div class="recent_heading">
                  <h4>Online Users</h4>
                </div>
                <div class="srch_bar">
                  <div class="stylish-input-group">
                    <input type="text" class="search-bar"  placeholder="Search" >
                    <span class="input-group-addon">
                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                    <a href="?logout=1"><img src="power-off.png" alt="disconnect"></a>
                    </span> 
                  </div>
                </div>
        </div>

        <div class="inbox_chat">
          <?php 
            $users = get_online_users($_SESSION['user_id']);
            display_online_users($users);
          ?>
        </div>
      </div>
        
      <div class="mesgs" >
        <div  id="chatbox" class="msg_history">
            <?php
              if(isset($_GET['id'])){
                $msgs = get_msgs($_GET['id'],$_SESSION['user_id']);
                if(!$msgs)
                  echo 'No messages sent yet, type a message in the input box below and press enter or the submit button';
                else
                  display_msgs($msgs);
              }else
                echo "Click on an online user to start chatting !";
            ?>
      </div>
      <div class="type_msg">
        <div class="input_msg_write">
          <form action="chat.php?id=<?php echo $_GET['id'];?>" method="post">
          <input name="user_msg" type="text" class="write_msg" placeholder="Type a message" />
          <a href="file_upload.php?id=<?php echo $_GET['id'];?>"><button class="msg_send_btn" type="button"><i class="fa fa-file" aria-hidden="true"></i></button></a>
          <button name="new_msg" class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>     
    <script>
      var chatbox = document.getElementById('chatbox');
      chatbox.scrollTop = chatbox.scrollHeight;
    </script> 
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
    