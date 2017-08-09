<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sell A Tool</title>
<style>
html, body {
	text-align: center;
	margin: 0px auto;
	padding-top:20px
}
</style>
</head>
<body>
	<h2>Sell Price</h2>
	<form  action="ClerkMainMenu.html" method="post">
		<span>
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
$ToolID=$_POST["input_text"];
$query="SELECT round(PurchasePrice/2,2) AS SellPrice FROM TOOLS WHERE ToolID='$ToolID'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_row($result);

$query2="SELECT T.ToolID, C.RID, R.ClerkPickup, R.ClerkDropOff FROM TOOLS as T, CONTAIN as C, RESERVATION as R"
        . " WHERE C.ToolID='$ToolID' and C.RID = R.ResID and R.CleakDropoff = NULL and R.ClerkPickup != NULL ";
$result2=mysqli_query($dbc,$query2);
$row2=mysqli_fetch_row($result);

if(!$row){
	echo "No such tool!";
	exit ();
}
elseif ($row) {
        echo "This tool has been checked out! No sell at this moment.";
        exit ();
}
else{
    echo "Sell price is $" . $row[0];
    $query1="UPDATE TOOLS SET ClerkSellTool='$login' WHERE ToolID='$ToolID'";
    $result1=mysqli_query($dbc,$query1);
    if(!$result1){
            echo "Sorry, we can not sell this tool at this moment!";
                  }
    }
mysqli_close ( $dbc );
?></span><br>
		<br> 
		<br> <input id="submit" type="submit" value="Back to Main Menu">
	</form>
	<p>
	
	</p>
</body>
</html>

