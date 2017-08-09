<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Rental Receipt</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top:20px
}
</style>
</head>
<body>
<p>HANDYMAN TOOLS RECEIPT
</p>
<?php
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$login=$_SESSION['clerk'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (! $dbc) {
	echo "Cannot connect to database.";
	exit ();
}

//looking up reservation through ResID
$ResID=$_POST['input_text'];


$query0="UPDATE RESERVATIONS SET ClerkDropOff='$login'WHERE ResID='$ResID'";
$result0=mysqli_query($dbc,$query0);
if (!$result0) {
	echo "Error, can not drop off this reservation.";
	exit();
}

$query="SELECT UCl.FirstName, UCl.LastName, UCu.FirstName, UCu.LastName, R.ResStartDate, R.ResEndDate, SUM(T.RentPrice*DATEDIFF(R.ResEndDate,R.ResStartDate)) AS RentalPrice, SUM(T.Deposit), R.CreditCardNo, SUM(T.RentPrice* DATEDIFF (R.ResEndDate,R.ResStartDate)-T.Deposit) AS Total FROM RESERVATIONS AS R, USER AS UCl, USER AS UCu, TOOLS AS T, CONTAIN AS C WHERE R.ResID='$ResID' AND UCl.Email=R.ClEmailDropoff AND UCu.Email=R.CuEmail AND C.RID=R.ResID AND C.TID=T.ToolID GROUP BY R.ResID";

$result=mysqli_query($dbc,$query);

if (!$result) {
	echo "No match receipts";
	exit();
}
$row=mysqli_fetch_row($result);
$clname=$row[0] . " " . $row[1];
$cuname=$row[2] . " " .$row[3];
$cardNo=$row[8];
$startdate=$row[4];
$enddate=$row[5];
$rentprice=$row[6];
$deposit=$row[7];
$total=$row[9];

?>
<form action="ClerkMainMenu.html" method="post">
		<table>
			<tr>
				<td align="left">Reservation Number:</td>
				<td><label for="res_num"><?php echo $ResID; ?></label></td>
				<td align="left">Clerk on Duty:</td>
				<td><label for="clerk"><?php echo $clname; ?></label></td>
			</tr>
			<tr>
				<td align="left">Customer Name:</td>
				<td><label for="customer"><?php echo $cuname; ?></label></td>
				<td align="left">Credit Card#:</td>
				<td><label for="credit_card"><?php echo $cardNo; ?></label></td>
			</tr>
			<tr>
				<td align="left">Start Date:</td>
				<td><label for="start_date"><?php echo $startdate; ?></label></td>
				<td align="left">End Date:</td>
				<td><label for="credit_card"><?php echo $enddate; ?></label></td>
			</tr>
			<tr>
				<td align="left">Rental Price:</td>
				<td><label for="price"><?php echo "$".$rentprice; ?></label></td>
			</tr>
			<tr>
				<td align="left">Deposit Held:</td>
				<td><label for="deposit"><?php echo "$".$deposit; ?></label></td>
			</tr>
			<tr>
				<td align="left">---------------</td>
			</tr>
			<tr>
				<td align="left">Total:</td>
				<td><label for="deposit"><?php echo "$".$total; ?></label></td>
			</tr>
			<tr>
			<td></td><td></td><td><input id="submit" type="submit" value="Back to Main Menu"></td>
			</tr>
		</table>		
	</form>

</body>
</html>

	