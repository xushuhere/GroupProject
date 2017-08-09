<?php
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$ClLogin=$_SESSION['clerk'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (! $dbc) {
	echo "Cannot connect to database.";
	exit ();
}

$TID = mysqli_real_escape_string ( $dbc, trim ( $_POST ["TID"] ) );
$start_date = mysqli_real_escape_string ( $dbc, trim ( $_POST ["start_date"] ) );
$end_date = mysqli_real_escape_string ( $dbc, trim ( $_POST ["end_date"] ) );
$cost =floatval(mysqli_real_escape_string ( $dbc, trim ( $_POST ["cost"] )) );

$query0="SELECT *
FROM TOOLS
WHERE ToolID='$TID' AND ToolID NOT IN (
SELECT C.TID
FROM RESERVATIONS AS R, CONTAIN AS C
WHERE CURDATE()<=R.ResEndDate AND CURDATE()>=R.ResStartDate AND R.ResID=C.RID)";
$result0=mysqli_query ( $dbc, $query0 );
if(!$result0){
	echo "This tool can not be serviced now.";
	exit();
}
$query = "INSERT INTO SERVICE_REQUEST VALUES ('$ClLogin','$TID','$start_date','$end_date',$cost)";

$result=mysqli_query ( $dbc, $query );

if($result)
	header ("Location: ClerkMainMenu.html");
else 
	header ("Location: ServiceOrder.html");
	// }
	
mysqli_close ( $dbc );

?>