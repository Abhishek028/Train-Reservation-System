

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
            a {
                color: red;
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



            <?php
            require_once 'login.php';
            session_start();
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

            if($connection->connect_error) die($connection->connect_error);

            $source = $_GET['source'];
            $destination=$_GET['destination'];
            $date = $_GET['date'];
            $class = $_GET['class'];
            $nopass = $_GET['nopass1'];
            $count = 1;
            $names = array();$age = array() ;$gender = array();

            while($count <= $nopass){
                $name[$count] = $_GET['name'.$count];
                $age[$count] = $_GET['age'.$count];
                $gender[$count] = $_GET['gender'.$count];
                $count = $count + 1;
            }
            $_SESSION['name'] = $name;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['source'] = $source;
            $_SESSION['destination'] = $destination;
            $_SESSION['class'] = $class;
            $_SESSION['date'] = $date;
            $_SESSION['nopass'] = $nopass;

            $day = date("l",strtotime($date));
            $sourceidquery = "select place_id from places where place_name='$source'";

            $result = $connection->query($sourceidquery);
            $sourceid;
            if(!$result) die($connection->error);



            elseif($result->num_rows)
            {
                global $sourceid;
                $row = $result->fetch_array(MYSQLI_NUM);
                $sourceid = $row[0];

                $result->close();
                //echo $sourceid;

            }

            $destinationidquery = "select place_id from places where place_name='$destination'";

            $result = $connection->query($destinationidquery);
            $destinationid;


            if(!$result) die($connection->error);

            elseif($result->num_rows)
            {
                global $destinationid;
                $row = $result->fetch_array(MYSQLI_NUM);
                $destinationid = $row[0];

                $result->close();

                //echo $destinationid;



            }

            $findtrain = "select * from train where source='$sourceid' and destination='$destinationid' and $day='y' and (class_id = '$class' or class_id = 'b')";
            $result = $connection->query($findtrain);


            if(!$result) die($connection->error);

            elseif($result->num_rows)
            {
                echo"<center>";
                echo "<h1>Following is the list of all trains running between $source and $destination railway stations :</h1>";

                echo "<table>";

                echo "<tr>";
                echo "<th>"."Train ID"."</td>";
                echo "<th>"."Train Name"."</td>";
                echo "<th>"."Source"."</td>";
                echo "<th>"."Destination"."</td>";
                echo "<th>"."Class"."</td>";
                echo "<th>"."Monday"."</td>";
                echo "<th>"."Tuesday"."</td>";
                echo "<th>"."Wednesday"."</td>";
                echo "<th>"."Thursday"."</td>";
                echo "<th>"."Friday"."</td>";
                echo "<th>"."Saturday"."</td>";
                echo "<th>"."Sunday"."</td>";
                echo "<th>"."Departure"."</td>";
                echo "<th>"."Arrival"."</td>";
                echo "</tr>";


                while($row = $result->fetch_array(MYSQLI_NUM))
                {
                    echo "<tr>";

                    echo '<td><a href="bookticket.php?train_no='.$row[0].'">'.$row[0].'</a>';
                    echo "<td>".$row[1]."</td>";
                    echo "<td>".$source."</td>";
                    echo "<td>".$destination."</td>";
                    echo "<td>".$class."</td>";
                    echo "<td>".$row[5]."</td>";
                    echo "<td>".$row[6]."</td>";
                    echo "<td>".$row[7]."</td>";
                    echo "<td>".$row[8]."</td>";
                    echo "<td>".$row[9]."</td>";
                    echo "<td>".$row[10]."</td>";
                    echo "<td>".$row[11]."</td>";
                    echo "<td>".$row[12]."</td>";
                    echo "<td>".$row[13]."</td>";


                    echo "</tr>";
                }
                echo <<<_END
</table>
</center>

_END;
                //$result->close();
                //echo $sourceid;

            }


            else
            {

                echo '<script type="text/javascript">alert("Trains not available between the selected route");window.location.href = "reservationstart.php";</script>';
                $result->close();

            }

            ?>

        </body>
    </div>
</html>
