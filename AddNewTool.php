<?php

session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$ClAddTool=$_SESSION['clerk'];


$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (! $dbc) {
	echo "Cannot connect to database.";
	exit ();
}
$AbbrDes = mysqli_real_escape_string ( $dbc, trim ( $_POST ["AbbrDes"] ) );
$pur_price = floatval(mysqli_real_escape_string ( $dbc, trim ( $_POST ["pur_price"] ) ));
$rental_price = floatval(mysqli_real_escape_string ( $dbc, trim ( $_POST ["rental_price"] ) ));
$deposit = floatval(mysqli_real_escape_string ( $dbc, trim ( $_POST ["deposit"] ) ));
$des = mysqli_real_escape_string ( $dbc, trim ( $_POST ["des"] ) );
$catalog =mysqli_real_escape_string ( $dbc, trim ($_POST ["tooltype"]) ); 
$TID = rand ( 0, 100000 );

$query1 = "SELECT ToolID FROM TOOLS WHERE ToolID='$TID'";
// $result1 = mysqli_query ( $dbc, $query );
 while ( mysql_query($query1)) {
	$TID = rand ( 0, 1000 );
	$query1 = "SELECT ToolID FROM TOOLS WHERE ToolID='$TID'";
}
// $query = "INSERT INTO TOOLS (ToolID,ClEmailAddTool,AbbrDes,FullDes,PurchasePrice,RentPrice,Deposit) VALUES ($TID,'anna@gmail','Sdasdasd','dasdasdas',1.00,1.00,1.00)";

$query = "INSERT INTO TOOLS (ToolID,AbbrDes,FullDes,PurchasePrice,RentPrice,Deposit,ToolType) VALUES ($TID,'$AbbrDes','$des',$pur_price,$rental_price,$deposit,'$catalog')";
$result = mysqli_query ( $dbc, $query );

if(strcmp($catalog, "Power") == 0){
	$access=$_POST['accessories'];
	$query2="INSERT INTO POWER_TOOLS_ACCES VALUES ($TID,'$access')";
	$result2 = mysqli_query($dbc,$query2);
	if(!$result2){
		echo "Add power tool accessories error." ;
	}
}


if ($result){
	header ( "Location: ClerkMainMenu.html" );
	exit;
}
else{
	echo "Error, can not add this tool!";
	echo $query;
}
mysqli_close ( $dbc );
?>