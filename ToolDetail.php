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
	width: 200px;
}
</style>
</head>
<body>
<h2>Tool Detail</h2>
<table>
			<tr>
				<td align="left">
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
$TID = mysqli_real_escape_string ( $dbc, trim ( $_POST ['part_num'] ) );

if ($TID){
$query = "SELECT AbbrDes,FullDes,PurchasePrice,RentPrice,Deposit FROM TOOLS WHERE ToolID='$TID'";
$result = mysqli_query ( $dbc, $query );

    if (! $result) {
	echo "No such tool";
	exit ();
    }
    else {
    $row=mysqli_fetch_row($result);
    
        if(!row){
            echo "No such tool!";
            }
        else{
            echo "Tool ID : " . $TID;
            echo "<br>";
            echo "Abbreviation description : " . $row[0];
            echo "<br>";
            echo "Full description : " . $row[1];
            echo "<br>";
            echo "Purchase  price: $" . $row[2];
            echo "<br>";
            echo "Rental price : $" . $row[3];
            echo "<br>";
            echo "Deposit : $" . $row[4];
            }
        }
}
mysqli_close($dbc);
?>
</td>
</tr>
<tr></tr>
<tr>
<td><button class="buttonsize" id="back" type="button" onClick="location.href='CustMainMenu.html'">Back to Main Menu</button>
</td>
</tr>
</table>
</body>
</html>