<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>First Report</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
<h2>First Report</h2>
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

$query = "SELECT T.ToolID, T.AbbrDes, SUM(DATEDIFF (R.ResEndDate,R.ResStartDate)*T.RentPrice) AS RentalProfit, T.PurchasePrice+SUM(S.EstCost) AS ToolCost, SUM(DATEDIFF (R.ResEndDate,R.ResStartDate)*T.RentPrice)-(T.PurchasePrice+SUM(S.EstCost)) AS TotalProfit 
FROM TOOLS AS T, RESERVATIONS AS R, SERVICE_REQUEST AS S
WHERE T.ToolID=S.TID
GROUP BY T.ToolID
ORDER BY TotalProfit";
$result = mysqli_query ( $dbc, $query );

if (! $result) {
	echo "No match contracts";
	exit ();
}

?>
<p>

<?php
				while ( $row1 = mysqli_fetch_assoc ( $result ) ) {
					foreach ( $row1 as $cname => $cvalue ) {
						print "$cname: $cvalue\t";
					}
					echo "<br>";
// 					print "\r\n";
				}
				mysqli_close($dbc);
				?>
				</p>
</body>
</html>