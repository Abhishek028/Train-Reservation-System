<?php
require_once 'login.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if($connection->connect_error) die($connection->connect_error);
$pnr = $_POST['pnr'];

$query = "select * from ticket where pnr = '$pnr'";
$result = $connection->query($query);
if(!$result) die($connection->error);
$row = $result->fetch_array(MYSQLI_NUM);
if(!$row) echo '<script type="text/javascript">alert("Pnr does not exist");window.location.href = "cancelticket.html";</script>';

$query = "select * from passenger where pnr = $pnr and waiting = '0'";
$result = $connection->query($query);
if(!$result) die($connection->error);
$row = $result->fetch_array(MYSQLI_NUM);
$noofemptyseats = $result->num_rows;

$query = "select class,train_no from ticket where pnr = '$pnr'";
$result = $connection->query($query);
if(!$result) die($connection->error);
$row = $result->fetch_array();
$train_no = $row[1];
$coach_type = $row[0];

$queryforseats = "select no_of_seats from class c where train_no='$train_no' and coach_type = '$coach_type'";



$resultforseats = $connection->query($queryforseats);
if(!$resultforseats) die($connection->error);
$row = $resultforseats->fetch_array(MYSQLI_NUM);
$noofseats = $row[0];


$noofseats = $noofseats + $noofemptyseats;


$queryforseatnumbers = "select seat from passenger where pnr = '$pnr' and waiting = '0' order by seat";//this will give the seat numbers to be allocated
$resultforseatnumbers = $connection->query($queryforseatnumbers);
if(!$resultforseatnumbers) die($connection->error);


$queryfordeletion = "delete from ticket where pnr = '$pnr'";
$resultfordeletion = $connection->query($queryfordeletion);
if(!$resultfordeletion) die($connection->error);


$queryforseats = "update class set no_of_seats = '$noofseats' where train_no = '$train_no' and coach_type = '$coach_type'";
$resultforseats = $connection->query($queryforseats);
if(!$resultforseats) die($connection->error);

$queryforstatus = "select * from passenger p,ticket t where p.pnr = t.pnr and   p.waiting != '0' and t.train_no = '$train_no' order by p.waiting";
$resultforstatus = $connection->query($queryforstatus);
if(!$resultforstatus) die($connection->error);


$noofrows = $resultforstatus->num_rows;

$i = 0;

while($i < $noofrows && $i < $noofseats){

    $array = $resultforstatus->fetch_array();
    $seat = $resultforseatnumbers->fetch_array();
    $pnr =  $array['pnr'];
    $passenger_id = $array['passenger_id'];

    $query = "update passenger set waiting = '0',seat = '$seat[0]' where pnr = '$pnr' and passenger_id = '$passenger_id'";

    $result = $connection->query($query);
    if(!$result) die("error");




    $queryforseats = "select no_of_seats from class where train_no='$train_no' and coach_type = '$coach_type'" ;
    $resultforseats = $connection->query($queryforseats);
    if(!$resultforseats) die($connection->error);
    $row = $resultforseats->fetch_array(MYSQLI_NUM);
    $row[0] = $row[0] - 1;
    $queryforseats = "update class set no_of_seats = '$row[0]' where train_no = '$train_no' and coach_type='$coach_type'";
    $resultforseats = $connection->query($queryforseats);
    if(!$resultforseats) die($connection->error);

    $i = $i + 1;

}


$queryforchangingwaiting = "select t.pnr,p.passenger_id from passenger p,ticket t where p.waiting!='0' and t.pnr = p.pnr and t.train_no = '$train_no' order by waiting";
$resultforchangingwaiting = $connection->query($queryforchangingwaiting);

if(!$resultforchangingwaiting) die($connection->error);
$i = 0;
echo $i;
while($row = $resultforchangingwaiting->fetch_array())
{
    $i = $i + 1;
    $queryforrearrangingwaiting = "update passenger set waiting = '$i' where pnr = '$row[0]' and passenger_id = '$row[1]'";
    $resultforrearrangingwaiting = $connection->query($queryforrearrangingwaiting);
    if(!$resultforrearrangingwaiting) die($connection->error);
    
}

$queryforsettingwaiting = "update waiting set no_of_waiting = '$i' where train_no = '$train_no' and coach_type = '$coach_type'";
$resultforsettingwaiting = $connection->query($queryforsettingwaiting);
if(!$resultforsettingwaiting) die($connection->error);
echo '<script type="text/javascript">alert("Cancelled ticket");window.location.href = "cancelticket.html";</script>';


?>