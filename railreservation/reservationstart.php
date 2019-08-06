<?php
require_once 'login.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

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
            .block {

                width: 100%;
                border: none;
                background-color: cyan;
                padding: 10px 28px;
                font-size: 16px;
                cursor: pointer;
                text-align: center;
            }

        </style>
        <title>railway reservation form </title>

        <script type='text/javascript'>
            function addFields(){
                // Number of inputs to create
                var number = document.getElementById("no.pass").value;
                // Container <div> where dynamic content will be placed
                var container = document.getElementById("container");
                // Clear previous contents of the container
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);

                }
                for (i=0;i<number;i++){
                    // Append a node with a random text

                    var tr1 = document.createElement("tr");
                    var tr2 = document.createElement("tr");
                    var tr3 = document.createElement("tr");
                    var td1 = document.createElement("td");
                    var td2 = document.createElement("td");
                    var td3 = document.createElement("td");
                    var td4 = document.createElement("td");
                    var td5 = document.createElement("td");
                    var td6 = document.createElement("td");
                    var select = document.createElement("select");
                    select.setAttribute("style","width:100%;box-sizing: border-box");
                    var option1 = document.createElement("option");
                    option1.value="Male";
                    option1.innerHTML = "Male";
                    var option2 = document.createElement("option");
                    option2.value="Female";
                    option2.innerHTML = "Female";
                    select.appendChild(option1);
                    select.appendChild(option2);
                    var txt = document.createTextNode("Name" + (i+1) + ":");
                    var input = document.createElement("input");
                    input.type = "text";
                    input.name = "name" + (i+1);
                    input.required = true;
                    td1.appendChild(txt);
                    td2.appendChild(input);
                    tr1.appendChild(td1);
                    tr1.appendChild(td2);
                    container.appendChild(tr1);
                    txt = document.createTextNode("Age" + (i+1) + ":");
                    input = document.createElement("input");
                    input.type = "number";
                    input.name = "age" + (i+1);
                    input.required = true;
                    input.min = "1";
                    input.onkeypress = function(event){return event.charCode > 48};
                    td3.appendChild(txt);
                    td4.appendChild(input);
                    tr2.appendChild(td3);
                    tr2.appendChild(td4);
                    container.appendChild(tr2);
                    txt = document.createTextNode("Gender"+(i+1)+":");
                    select.name = "gender" + (i+1);
                    td5.appendChild(txt);
                    td6.appendChild(select);
                    tr3.appendChild(td5);
                    tr3.appendChild(td6);
                    container.appendChild(tr3);

                }
                var tr = document.createElement("tr");
                var td = document.createElement("td");
                td.colSpan = "2";
                var input = document.createElement("input");
                input.type = "submit";
                input.className = "block"
                td.appendChild(input);
                tr.appendChild(td);
                container.appendChild(tr);
            }
        </script>
    </head>
    <div class="main">
        <body >
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
            <form name="railway" id = "form" action="reservation.php" method="get">
                <center>
                    <h1 style="color:black;"><marquee >Railway Reservation System </marquee> </h1>

                    <table id="table" border="2">
                        <tr>
                            <td>From:</td>
                            <td><select name='source'  style = "width:100%;box-sizing: border-box">
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
                            <td>To:</td>
                            <td ><select name='destination'  style = "width:100%;box-sizing: border-box">
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
                            <td><input type="date" name="date"  style = "width:100%;box-sizing: border-box" required>
                            </td>
                        </tr>

                        <tr>
                            <td>No. Passengers:</td>
                            <td><input type="number" name="nopass1" id="no.pass" onkeypress="return event.charCode > 48" min="1" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Classes:</td>
                            <td><select name='class' style = "width:100%;box-sizing: border-box">
                                <option value ="g">General</option>
                                <option value ="ac">Air Conditioned</option>
                                
                                </select>
                            </td>
                        </tr> 

                        <tr>
                            <td colspan="2"> <button type="button" class="block" onclick="addFields()">Add Passenger</button>

                            </td>
                        </tr>

                        <tbody id="container"> </tbody>




                    </table>



                </center>
            </form>

        </body>
    </div>
</html>