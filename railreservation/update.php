<?php
require_once 'login.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if($connection->connect_error) die($connection->connect_error);
session_start();
$user_id = $_SESSION['user_id'];
$query = "select * from users where user_id = '$user_id'";
$result = $connection->query($query);
$row = $result->fetch_array();

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
                color: black;
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
            form { 

                width: 50%;
                opacity: 0.7;
            }

            input[type=text], input[type=password] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }

            button {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
            }

            button:hover {
                opacity: 0.8;
            }

            .imgcontainer {
                text-align: center;
                margin: 24px 0 12px 0;
            }

            img.avatar {
                width: 10%;
                border-radius: 50%;
            }

            .container {
                padding: 16px;
                background:#f1f1f1;

            }

            span.register {
                float: right;
                padding-top: 16px;
            }

        </style>
    </head>
    <div class = "main">
        <body>
            <div class="navbar"  style = " text-align: center;">
                <div style="display: inline-block">
                    <a href="Welcome.html">Home</a>
                    <a href="reservationstart.php">Book Ticket</a>
                    <a href="cancelticket.html">Cancel Ticket</a>
                    <a href="pnrenquiry.html">PNR Enquiry</a>
                    <a href="update.php">Update Profile</a>

                    <a href="loginform.html">Logout</a>
                </div>
            </div>
            <div id="outer" align = "center">
                <form method = "post" action="authenticateupdate.php">
                    <div class="imgcontainer">

                        <img src="user.png" alt="Avatar" class="avatar">
                    </div >

                    <div class="container">
                        <label for="uname"><b>Username</b></label>
                        <input type="text" placeholder= "<?php echo $row[1] ?>"  name="uname" required>



                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="<?php echo $row[3] ?>" name="email" required>


                        <label for="phone"><b>Phone Number</b></label>
                        <input pattern="[1-9]{1}[0-9]{9}" type="text" placeholder="<?php echo $row[4] ?>"name="phone" required>


                        <label for="psw"><b> Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" required>

                        <button type="submit">Update Profile</button>
                    </div>


                </form>
            </div>


        </body>
    </div>

</html>

