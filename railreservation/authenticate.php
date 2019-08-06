<!DOCTYPE html>
<html>
    <head>
        <style>

            body {
                position: absolute;
                top: 0; bottom: 0; left: 0; right: 0;
                height: 100%;
                color: white;
            }
            body:before {
                content: "";
                position: absolute;
                background: url(train4.jpg);
                background-size: cover;
                z-index: -1; /* Keep the background behind the content */
                height: 20%; width: 20%; /* Using Glen Maddern's trick /via @mente */

                /* don't forget to use the prefixes you need */
                transform: scale(5);
                transform-origin: top left;
                filter: blur(1px);
            }
        </style>
        <body></body>
    </head>
</html>


<?php
require_once 'login.php';
session_start();

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if($connection->connect_error) die($connection->connect_error);

$uname = $_POST['uname'];
$pass  = $_POST['psw'];

$query = "select user_id from users where username='$uname' and password = '$pass'";

$result = $connection->query($query);

if(!$result) die($connection->error);

elseif($result->num_rows)
{
    $row = $result->fetch_array(MYSQLI_NUM);
    $result->close();

    $_SESSION['user_id'] = $row[0];

    header("Location: http://localhost//welcome.php");

    exit();
}

else echo '<script type="text/javascript">setTimeout(function () {
alert("Username or Password is wrong");

},500);setTimeout(function () {window.location.href = "loginform.html";},501); </script>';



?>





