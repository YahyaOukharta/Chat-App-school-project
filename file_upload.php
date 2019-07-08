<?php
    session_start();
    if(!isset($_SESSION['user_id']) || !isset($_GET['id']))
        header("location: index.php");

    include("functions/get_data.php");
    include("functions/db.php");

    $dest_username = get_user_data($_GET['id'])['username'];

    print_r($_FILES);
    if(isset($_FILES['fileToUpload']))
    {
        $errors= array();
        $file_name = $_FILES['fileToUpload']['name'];
        $file_size =$_FILES['fileToUpload']['size'];
        $file_tmp =$_FILES['fileToUpload']['tmp_name'];
        $file_type=$_FILES['fileToUpload']['type'];
        
        if($file_size > 2097152 || $file_size == 0 || empty($file_type));
           //$errors[]='File size must be less than 2 MB';
        
        if(empty($errors)){
            move_uploaded_file($file_tmp,"uploaded_files/".$file_name);
            $content = $file_name;
            $src = $_SESSION['user_id'];
            $dest = $_GET['id'];

            $sql= "INSERT INTO msgs(source_id,dest_id,content,type) /* add the msg as tyoe file to the msgs table */
                    VALUES ( '$src' , '$dest','$content','file');";
            $sql2= "INSERT INTO files(file_name,file_size,file_type,msg_id) /* add the file to the files table */
                    VALUES ( '$file_name' , '$file_size','$file_type',(select MAX(msg_id) from msgs))" ;
            if(!mysqli_query($con,$sql))
                echo mysqli_error($con);
            else if(!mysqli_query($con,$sql2))
                echo mysqli_error($con);
            echo "Success";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Send a file to <?php echo $dest_username; ?></title>
 
</head>
<body>
    <h4>Upload a file and click the button to send it to <?php echo $dest_username;?></h1>
    <br><br>
    <form action="file_upload.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" >
        <input type="submit" name="upload" value="UPLOAD">
    </form>
</body>
</html>