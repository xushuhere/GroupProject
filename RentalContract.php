<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Rental Contract</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
	<p>HANDYMAN TOOLS RENTAL CONTRACT</p>
<?php
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$clerk=$_SESSION['clerk'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );

if (! $dbc) {
	echo "Cannot connect to database.";
	exit ();
}
$ResID = $_POST['RID'];
$creditcard= mysqli_real_escape_string ( $dbc, trim ( $_POST ['CreditCardNo'] ) );
$expdate= mysqli_real_escape_string ( $dbc, trim ( $_POST ['ExpDate'] ) );

$query0="UPDATE RESERVATIONS SET ClEmailPickUp='$clerk', CreditCardNo = '$creditcard', ExpDate ='$expdate'WHERE ResID='$ResID'";
$result0 = mysqli_query ( $dbc, $query0 );
if (! $result0) {
	echo "Error can not complete pick up.";
	exit ();
}


$query = "SELECT UCl.FirstName, UCl.LastName, UCu.FirstName, UCu.LastName, R.ResStartDate, R.ResEndDate, SUM(T.RentPrice*DATEDIFF(R.ResEndDate,R.ResStartDate)) AS RentalPrice, SUM(T.Deposit), R.CreditCardNo, SUM(T.RentPrice* DATEDIFF (R.ResEndDate,R.ResStartDate)-T.Deposit) AS Total FROM RESERVATIONS AS R, USER AS UCl, USER AS UCu, TOOLS AS T, CONTAIN AS C WHERE R.ResID='$ResID' AND UCl.Email=R.ClEmailDropoff AND UCu.Email=R.CuEmail AND C.RID=R.ResID AND C.TID=T.ToolID GROUP BY R.ResID";
$result = mysqli_query ( $dbc, $query );

if (! $result) {
	echo "No match contracts";
	exit ();
}
$row = mysqli_fetch_row ( $result );
$clname = $row [0] . " " . $row [1];
$cuname = $row [2] . " " . $row [3];
$cardNo = $row [8];
$startdate = $row [4];
$enddate = $row [5];
$rentprice = $row [6];
$deposit = $row [7];
$total = $row [9];

$query1 = "SELECT T.ToolID, T.AbbrDes FROM RESERVATIONS AS R, TOOLS AS T, CONTAIN AS C
WHERE R.ResID='$ResID' AND C.RID=R.ResID AND C.TID=T.ToolID;";
$result1 = mysqli_query ( $dbc, $query1 );
?>
<form action="ClerkMainMenu.html" method="get">
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
				<td align="left">Tools Rented:</td>
			</tr>
			<tr>
				<td><label for="tools"><?php
				while ( $row1 = mysqli_fetch_assoc ( $result1 ) ) {
					foreach ( $row1 as $cname => $cvalue ) {
						print "$cname: $cvalue\t";
					}
					print "\r\n";
				}
				?></label></td>
			</tr>
			<tr>
				<td align="left">Deposit Held:</td>
				<td><label for="deposit"><?php echo "$" . $deposit; ?></label></td>
			</tr>
			<tr>
				<td align="left">Estimated Rental:</td>
				<td><label for="est_rental"><?php echo "$" . $rentprice; ?></label></td>
			</tr>
			<tr>
				<td align="left">Signature:___________________</td>
			</tr>
			<tr></tr>
			<tr>
			<td></td><td></td><td><input id="submit" type="submit" value="Back to Main Menu"></td>
			</tr>
		</table>
	</form>
	<?php mysqli_close($dbc);?>
</body>
</html>