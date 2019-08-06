<?php
require_once 'login.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if($connection->connect_error) die($connection->connect_error);


$pnr = $_POST['pnr'];
$queryfortrain = "select train_no from ticket where pnr = '$pnr'";

$queryforpassenger = "select * from passenger where pnr = '$pnr'";



$resultfortrain = $connection->query($queryfortrain);
if(!$resultfortrain) die($connection->error);

$resultforpassenger = $connection->query($queryforpassenger);
if(!$resultforpassenger) die($connection->error);

$row = $resultfortrain->fetch_array();
if(!$row) echo '<script type="text/javascript">setTimeout(function(){alert("Username or Password is wrong");},9);window.location.href = "pnrenquiry.html";</script>';

$queryfortraindetails = "select train_id,train_name,source,destination,
class_id,departure,arrival from train where train_id = $row[0]";

$resultfortraindetails = $connection->query($queryfortraindetails);
if(!$resultfortraindetails) die($connection->error);
echo " f";
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
            }*/

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

            <table>
                <tr>
                    <th>Train No</th>
                    <th>Train Name</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Class</th>
                    <th>Arrival time</th>
                    <th>Departure time</th>
                </tr>
                <tr>
                    <?php
                    $row = $resultfortraindetails->fetch_array();
                    $i = 0;

                    while($i < 7){
                        echo "<td>";
                        if($i!=2 and $i!=3)
                            echo $row[$i];
                        else
                        { 
                            $query = "select place_name from places where place_id = '$row[$i]'";
                            $result = $connection->query($query);
                            if(!$result) die($connection->error);

                            $row1 = $result->fetch_array();
                            echo $row1[0];
                        }
                        echo "</td>";
                        $i = $i + 1;
                    }
                    ?>
                </tr>
            </table>

            <table>
                <tr>
                    <th>PNR</th>
                    <th>Passenger_id</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Waiting</th>
                    <th>Seat</th>
                    <th>Coach</th>
                </tr>

                <?php

                $i = 0;

                while($row = $resultforpassenger->fetch_array()){
                    echo "<tr>";
                    while($i < 8){
                        echo "<td>";

                        echo $row[$i];

                        echo "</td>";

                        $i = $i + 1;


                    }
                    $i = 0;
                    echo "</tr>";
                }
                ?>

            </table>
        </body>
    </div>
</html>