<?php
require_once 'login.php';
session_start();
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if($connection->connect_error) die($connection->connect_error);
$name = $_SESSION['name'];
$age = $_SESSION['age'];
$gender = $_SESSION['gender'];
$train_no = $_GET['train_no'];
$date = $_SESSION['date'];
$nopass = $_SESSION['nopass'];
$bookingdate = DateTime::createFromFormat('Y-m-d',$date);
$bookingdate->modify('-3 day');
$bookingdate = $bookingdate->format('Y-m-d');

$user_id = $_SESSION['user_id'];
$class = $_SESSION['class'];
$pnr = rand(1234,9999);
$total_fair = 0;
$source = $_SESSION['source'];
$destination =  $_SESSION['destination'];
$query = "insert into ticket values"."
('$pnr','$class','$date','$user_id','$train_no','$total_fair')";
$result = $connection->query($query);

while(!$result){
    $pnr = rand(1234,9999);
    $query = "insert into ticket values"."('$pnr','$class','$date','$user_id','$train_no','$total_fair')";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
}

$query = "call getFare('$pnr','$source','$destination','$class','$nopass')";
$result = $connection->query($query);
if(!$result) die($connection->error);

$query = "select fare from ticket where pnr = '$pnr'";
$result = $connection->query($query);
if(!$result) die($connection->error);
$row = $result->fetch_array();
$total_fair = $row[0];

$count = $_SESSION['nopass'];
while($count>0){
    $queryforseats = "select no_of_seats from class where train_no='$train_no' and coach_type='$class'" ;
    $resultforseats = $connection->query($queryforseats);
    if(!$resultforseats) die($connection->error);
    $row = $resultforseats->fetch_array(MYSQLI_NUM);

    if($row[0]>0){
        $query = "insert into passenger values"."('$pnr','$count','$name[$count]','$gender[$count]','$age[$count]','0','$row[0]','$class')";
        $result = $connection->query($query);
        if(!$result) die($connection->error);


        $row[0] = $row[0] - 1;
        $queryforseats = "update class set no_of_seats = '$row[0]' where train_no='$train_no' and coach_type = '$class'";
        $resultforseats = $connection->query($queryforseats);
        if(!$resultforseats) die($connection->error);


    }
    else{
        $queryforwaiting = "select * from waiting where train_no = '$train_no' and coach_type = '$class'";
        $result = $connection->query($queryforwaiting);
        if(!$result) die($connection->error);
        $row = $result->fetch_array(MYSQLI_NUM);
        $waiting = $row[2];
        $waiting = $waiting + 1;
        $queryforwaiting = "update waiting set no_of_waiting = '$waiting' where train_no = '$train_no' and coach_type = '$class'";
        $result = $connection->query($queryforwaiting);

        if(!$result) die($connection->error);
        $query = "insert into passenger values"."('$pnr','$count','$name[$count]','$gender[$count]','$age[$count]','$waiting',null,'$class')";
        $result = $connection->query($query);
        if(!$result) die($connection->error);
    }

    $count = $count - 1;

}
$query = "select train_name from train where train_id=".$train_no;
$result = $connection->query($query);
if(!$result) die($connection->error);
$row = $result->fetch_array(MYSQLI_NUM);
?>

<!DOCTYPE html>
<html>
    <head>

        <style>
            .main {
                padding: 16px;
                margin-top: 30px;
                height: 1500px; /* Used in this example to enable scrolling */
            }

            .navbar {
                overflow: hidden;
                background-color: #333;
                position: fixed;
                top: 0;
                width: 100%;

            }

            .navbar a {
                float: left;
                display: block;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;

            }

            .navbar a:hover {
                background: #ddd;
                color: black;
            }


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
            table { 
                width: 750px; 
                border-collapse: collapse; 
                margin:50px auto;
            }

            /* Zebra striping 
            tr:nth-of-type(odd) { 
            background: #eee; 
            } */
            th { 
                background: #3498db; 
                color: white; 
                font-weight: bold; 
            }

            td, th { 
                padding: 10px; 
                border: 1px solid #ccc; 
                text-align: left; 
                font-size: 18px;
            }




        </style>
    </head>
    <div class="main">
        <?php
        echo <<<_END

    <body>
    <div class="navbar"  style = " text-align: center;">
                    <div style="display: inline-block">
            <a href="Welcome.php">Home</a>
            <a href="reservationstart.php">Book Ticket</a>
            <a href="cancelticket.html">Cancel Ticket</a>
            <a href="pnrenquiry.html">PNR Enquiry</a>
            <a href="update.php">Update Profile</a>

            <a href="loginform.html">Logout</a>
        </div>
        </div>
    <center>
    <table class="pure-table">
    <tr>
    <td>Transaction ID:1234567</td>
    <td>PNR No: $pnr</td>
    <td>Class: $class</td>
    </tr>
    <tr>
    <td>Train No. & Name: $train_no & $row[0]</td>
    <td>Date of Journey: $date</td>
    <td>Distance: 2314</td>
    </tr>
    <tr>
    <td>Date of Booking: $bookingdate </td>
    <td>Date of Boarding: $date</td>
    <td>Quota: Tatkal</td>
    </tr>
    <tr>
    <td>From: $source</td>
    <td>To: $destination</td>
    <td>Total Fare: Rs $total_fair</td>
    </tr>
    </table>
    <br><br>
    <table>
    <tr>
    <th>SNo.</th>
    <th>Name</th>
    <th>Age</th>
    <th>Sex</th>
    <th>Booking Status</th>
    <th>Seat</th>
    </tr>
_END;
        $count = $_SESSION['nopass'];
        $sno = 1;
        while($sno<=$count){
            echo "<tr>";
            echo "<td>";
            echo $sno;
            echo "</td>";
            echo "<td>";
            echo $name[$sno];
            echo "</td>";
            echo "<td>";
            echo $age[$sno];
            echo "</td>";
            echo "<td>";
            echo $gender[$sno];
            echo "</td>";
            $query = "select waiting,seat from passenger where passenger_id = $sno and pnr = $pnr";
            $result = $connection->query($query);
            if(!$result) die($connection->error);
            $row = $result->fetch_array(MYSQLI_NUM);
            $status = $row[0];
            $seat = $row[1];
            echo "<td>";
            if($status)
                echo "waiting".$status;
            else
                echo "confirmed";
            echo "</td>";
            echo "<td>";
            echo $seat;
            echo "</td>";
            $sno = $sno+1;

        }
        ?>
    </div>
</html>
