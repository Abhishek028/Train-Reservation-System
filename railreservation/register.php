<?php
require_once 'login.php';

$connection = new mysqli($db_hostname,$db_username,$db_password,$db_database);

if($connection->connect_error) die($connection->connect_error);

$uname = $_POST['uname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$passw = $_POST['psw'];

$query = "insert into users (username,password,email,phone) values"."('$uname','$passw','$email','$phone')";

$result = $connection->query($query);

if(!$result) echo "insert failed: $query<br>".
    $connection->error."<br><br>";

else{
    include_once('loginform.html');
}


?>