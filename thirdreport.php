<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Final Report</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
<h2>Final Report</h2>
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

$query ="SELECT C.FirstName, C.LastName, COUNT(RP.ClerkPickUp) AS nPickup, COUNT(RD.ClerkDropOff) AS nDropoff, nDropoff+nPickuP as nTotal
FROM CLERKS AS C, RESERVATIONS AS RP,RESERVATIONS AS RD
WHERE (C.Email=RP.ClerkPickUp or C.Email = RD.ClerkDropOff)AND date_format(RP.ResStartDate,'%Y-%m')=date_format(now(),'%Y-%m')
GROUP C.FirstName, C.LastName
ORDER BY nTotal
Having nTotal > 1";

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
				
				//$query3 = "DROP VIEW temp1,temp2";
				//$result3 = mysqli_query ( $dbc, $query3 );
				//mysqli_close($dbc);
				?>
				</p>
</body>
</html>