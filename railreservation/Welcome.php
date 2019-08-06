<?php
require_once 'login.php';

$connection = new mysqli($db_hostname,$db_username,$db_password,$db_database);

if($connection->connect_error) die($connection->connect_error);
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
        <title>railway reservation form </title>

    </head>
    <div class="main"  style = "text-align: center;">
        <body >

           
                <h1 style="color:black;"><marquee >Railway Reservation System </marquee> </h1>
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

            
            <form method="get" action="findtrains.php">
                <center>



                    <table id="form">  


                        <tr>
                            <td>Source:</td>
                            <td><select name='source'  style = "width:100%;box-sizing: border-box">
                                <?php
                                $query = "select place_name from places";
                                $result = $connection->query($query);
                                if(!$result) die($connection->error);
                                while($row = $result->fetch_array()){
                                    echo "<option value='". $row['place_name'] ."'>" .$row['place_name'] ."</option>" ;
                                }
                                ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Destination:</td>
                            <td><select name='destination'  style = "width:100%;box-sizing: border-box">
                                <?php
                                $query = "select place_name from places";
                                $result = $connection->query($query);
                                if(!$result) die($connection->error);
                                while($row = $result->fetch_array()){
                                    echo "<option value='". $row['place_name'] ."'>" .$row['place_name'] ."</option>" ;
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td><input type="date" name="date" required></td></tr>
                        <tr>
                            <td>Classes:</td>
                            <td><select name='class'>
                                <option value ="g">General</option>
                                <option value ="ac">Air Conditioned</option>
                                
                                </select>
                            </td>
                        </tr> 


                    </table>
                </center>
                <center><input type="submit" value="Find Trains" ></center>
            </form>



        </body>
    </div>
</html>