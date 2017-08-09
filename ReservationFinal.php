
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reservation Final</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
.buttonsize {
	width: 240px;
}
</style>
</head>
<body>
    
    
<?php
/* connect to database */
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$email=$_SESSION['customer'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (!$dbc) {
	die("Cound not connect to database");
}

$startdate=$_POST['StartDate'];
$enddate=$_POST['EndDate'];
$rentprice=$_POST['price'];
$rentdeposit=$_POST['deposit'];

$toolsids=unserialize($_POST['tools']);


$ResID = rand ( 0, 10000000000 );

$query1 = "SELECT * FROM RESERVATIONS WHERE ResID='$ResID'";
while ( mysql_query($dbc,$query1)) {
	$ResID = rand ( 0, 10000000000 );
	$query1 = "SELECT * FROM RESERVATIONS WHERE ResID='$ResID'";
}
$query_res1="INSERT INTO RESERVATIONS (ResID,CuEmail,ResStartDate,ResEndDate) VALUES ('$ResID','$email','$startdate','$enddate')";
$result1=mysqli_query($dbc,$query_res1);

foreach($toolsids as $tid){	
$query_res2="INSERT INTO CONTAIN (RID,TID) VALUES ('$ResID','$tid')";
$result2=mysqli_query($dbc,$query_res2);

if(!$result1||!$result2){
	echo "Error:can not make reservation.";
	exit;
}
}

$tooldes=array();
$i=1;
foreach($toolsids as $tids){
$query_tool="SELECT AbbrDes FROM TOOLS WHERE ToolID='$tids'";
$result_tool=mysqli_query($dbc,$query_tool);
if(!$result_tool){
	echo "Error:No such tool.";
	exit;
}
$row=mysqli_fetch_row($result_tool);
$tooldes[$i-1]= $i. ". ".$row[0];
$i++;
}
?>
    <P>Your Reservation Number is</P>
	<P>
		<label for="resID"><?php echo $ResID; ?></label>
	</P>
	<p>Tools Rented</p>
	<p>
	<?php 
// 	if(is_array($toolids)){
// 		//this assumes your array is always like this Array ( [0] => [1] => Netherlands )
// 		echo $toolids[1];
// 	}
// 	else{
// 		echo $toolids;
// 	}
//  	echo $_POST['tools'];
	foreach($tooldes as $des){
		echo $des;
		echo "<br>";
	}
	 
	?>
	</p>
	

 <form action="CustMainMenu.html" method="post">
	<table>
	<tr>
		<td align="left">Start Date</td>
		<td><label for="resStartDate"><?php echo $startdate ?></label></td>
	</tr>
	<tr>
		<td align="left">End Date</td>
		<td><label for="resEndDate"><?php echo $enddate ?></label></td>
	</tr>
	<tr>
		<td align="left">Total Rental Price</td>
		<td><label for="total_rental_price "><?php echo "$".$rentprice ?> </label></td>
	</tr>
	<tr>
		<td align="left">Total Deposit Required</td>
		<td><label for="total_rental_deposit"><?php echo "$".$rentdeposit ?></label></td>
		</tr>
		</table>
		<br> <input name="enter" type="submit" value="Back to Main Menu">
</form>
</body>
</html>