<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pick Up</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top:20px
}
.buttonsize {
	width: 150px;
}
</style>
</head>
<body>
<?php
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );

if (! $dbc) {
	echo "Cannot connect to database.";
	exit ();
}


$ResID=mysqli_real_escape_string ( $dbc, trim ( $_POST ["input_text"] ) );

$query="SELECT SUM(T.RentPrice*DATEDIFF(R.ResEndDate,R.ResStartDate)) AS RentalPrice, SUM(T.Deposit)FROM RESERVATIONS AS R, TOOLS AS T, CONTAIN AS C WHERE R.ResID='$ResID' AND C.RID=R.ResID AND C.TID=T.ToolID GROUP BY R.ResID";

$result=mysqli_query($dbc,$query);

if (!$result) {
	echo "No match receipts";
	exit;
}

$row=mysqli_fetch_row($result);
$rentprice=$row[0];
$deposit=$row[1];

$query1 = "SELECT T.ToolID, T.AbbrDes FROM RESERVATIONS AS R, TOOLS AS T, CONTAIN AS C
WHERE R.ResID='$ResID' AND C.RID=R.ResID AND C.TID=T.ToolID";
$result1 = mysqli_query ( $dbc, $query1 );
?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<table>
			<tr>
				<td align="left">Reservation Number:</td>
				<td><label for="res_num"><?php if(!$row){
					echo "No such reservation!";
					exit;
				}
				echo $ResID ?></label></td>
			</tr>
			<tr>
				<td align="left">Tools Required:</td>
			</tr>
			<tr>
				<td><label for="tools"><?php
				$item=1;
				while ( $row1 = mysqli_fetch_assoc ( $result1 ) ) {
					print "$item. ";
					foreach ( $row1 as $cname => $cvalue ) {
						print "$cname: $cvalue\t";
					}
					$item++;
					print "\r\n";
				}
				?></label></td>
			</tr>
			<tr>
				<td align="left">Deposit Required:</td>
				<td><label for="deposit"><?php echo $deposit ?></label></td>
			</tr>
			<tr>
				<td align="left">Estimated Cost:</td>
				<td><label for="cost"><?php echo $rentprice ?></label></td>
			</tr>
		</table>
		</form>
		<hr />
		<form action="ToolDetail.php" method="post">
		<table>
			<tr>
				<td align="left">Tool ID</td>
				<td><input name="tid" type="text"></td>
				<td><input id="submit" type="submit" value="View Details"></td>
			</tr>
		</table>
		</form>
		<hr />
	<form action="RentalContract.php" method="post">
		<table>
			<tr>
				<td align="left">Credit Card Number</td>
				<td><input name="CreditCardNo" type="text"></td>
			</tr>
			<tr>
				<td align="left">Expiration Date</td>
				<td><input name="ExpDate" type="text"></td>
			</tr>
			<tr><td><input type="hidden" name="RID" value="<?php echo $ResID;?>" > </td></tr>
			<tr> <td><input id="submit" type="submit" value="Complete Pick-Up"></td>
			</tr>
		</table>
	</form>
	<?php mysqli_close($dbc);?>
</body>
</html>