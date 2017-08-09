<?php
/* connect to database */
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (!$dbc) {
	die("Cound not connect to database");
}

$tools=array();
$tools[0]=$_POST['tools'];
$k=2;
while($k<52&&$_POST['tools'.$k]!=null){
	$tools[$k-1]=$_POST['tools'.$k];
	$k++;
}


$toolids=array();
$i=0;
foreach($tools as $eachtools){
	$split=explode(" ", $eachtools);
	$toolids[$i]=$split[1];
	$i++;
}

$ResStartDate=$_POST['ResStartDate'];
$ResEndDate=$_POST['ResEndDate'];

$Price=0;
$Deposit=0;
foreach($toolids as $ids){
	
$query="SELECT RentPrice,Deposit FROM TOOLS WHERE ToolID='$ids'";
$result=mysqli_query($dbc,$query);
	if(!$result){
		echo "No tool selected.";
				exit;
	}
		
$result_row = mysqli_fetch_row($result);
$Price+=$result_row[0];
$Deposit+=$result_row[1];
}

$tidstring=serialize($toolids);

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reservation Summary</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
.buttonsize {
	width: 70px;
}
</style>
</head>
<body>
<h2>Reservation Summary</h2>
<p>
Tools Desired<br>
<?php 
// foreach ($_POST['tools'] as $rows){
// 	echo $rows;
// 	echo "<br>";
// }
// echo $_POST['tools'];



foreach($tools as $eachtool){
	echo $eachtool;
	echo "<br>";
}


?>
</p>


	<form action="ReservationFinal.php" method="post">
	<table>
		<tr>
		<td align="left">Start Date</td>
		<td><label for="resStartDate"><?php echo $ResStartDate; ?></label>
		<input type="hidden" name="StartDate" value="<?php echo $ResStartDate;?>" /></td>
		</tr>
		<tr>
		<td align="left">End Date</td>
		<td><label for="resEndDate"><?php echo $ResEndDate; ?></label>
		<input type="hidden" name="EndDate" value="<?php echo $ResEndDate;?>" /></td>
		</tr>
		<tr>
		<td align="left">Total Rental Price</td>
		<td><label for="total_rental_price"><?php echo "$".$Price; ?> </label>
		<input type="hidden" name="price" value="<?php echo $Price;?>" /></td>
		</tr>
		<tr>
		<td align="left">Total Deposit Required</td>
		<td><label for="total_deposit"><?php echo "$".$Deposit ?></label>
		<input type="hidden" name="deposit" value="<?php echo $Deposit;?>" />
		<input type="hidden" name="tools" value="<?php echo $tidstring;?>" /></td>
		</tr>
		</table>
		<br> <input id="submit" type="submit" value="Submit">
    	<button class="buttonsize" id="reset" type="button" onclick="location.href='MakeReservation.php'">Reset</button>
</form>
</body>
</html>