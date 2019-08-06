<!DOCTYPE html>
<html>

    <body>


        <?php
        session_start();
        $user_id = $_SESSION['user_id'];
        require_once 'login.php';
        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        if($connection->connect_error) die($connection->connect_error);
        $password = $_POST['psw'];

        $query = "select * from users where password = '$password' and user_id = '$user_id'";
        $result = $connection->query($query);
        if(!$result) die($connection->error);
        $rows = $result->fetch_array();
        if($rows)
        {$username = $_POST['uname'];
         $email = $_POST['email'];
         $phone = $_POST['phone'];
         $query = "update users set username = '$username',email='$email',phone='$phone' where user_id = '$user_id'";
         $result = $connection->query($query);
         if(!$result) die($connection->error);
         echo '<script>alert("Profile is updated");window.location.href = "update.php";</script>';
        }

        
        else
        {echo '<script>alert("Password is wrong");window.location.href = "update.php";</script>';
         
        }
            
        ?>


    </body>
</html>

