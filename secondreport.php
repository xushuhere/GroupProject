<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Second Report</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
<h2>Second Report</h2>
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

$firstdaylastmonth_q = "SELECT DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE())-1, 0)";
$lastdaylastmonth_q = "select DATEADD(MONTH, DATEDIFF(MONTH, -1, GETDATE())-1, -1)";

$query = "SELECT U.FirstName, U.LastName, U.Email, COUNT(C.TID) AS nRentals
FROM CUSTOMERS AS U, RESERVATIONS AS R, CONTAIN as C
WHERE U.Email=R.CuEmail AND R.StartDate >= DATEADD(m, -1, GETDATE()) AND R.StartDate <=GETDATE()
AND C.RID = R.ResID
GROUP BY R.CuEMail
ORDER BY nRentals, CU.LastName";

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