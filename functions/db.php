<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat_app";
$con = mysqli_connect($servername,$username,$password,$dbname);
if(!$con)
    die("error connecting to db : " . mysqli_connect_error());
