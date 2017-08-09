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


if (!isset($email)) {
/*no email handle over, go back to login page.*/
	header('Location: Login.php');
	exit();

}


/*$query_customer_profile = "SELECT Cu.Email FROM CUSTOMERS as Cu WHERE Cu.Email = '$email'";*/

                            
$query_customer_profile = "SELECT Cu.Email, Cu.FirstName, Cu.LastName,Cu.CountryCodeH, "
                            . "Cu.LocalNumH, Cu.CountryCodeW, Cu.LocalNumW, Cu.Address"
                            . " FROM CUSTOMERS as Cu "
                            . "WHERE Cu.Email = '$email'";
$result_profile = mysqli_query ( $dbc, $query_customer_profile) ;


if (!$result_profile) {
	echo "No such customer!\n";
        echo "\n$email";
	exit();
}

$row_cu= mysqli_fetch_array($result_profile);

if (!$row_cu) {
	print "<p>Error: No data returned from database.  Administrator login NOT supported.</p>";
	print "<a href='logout.php'>Logout</a>";
	exit();
}

$query_res_history = "SELECT R.ResID,T.ToolID, R.ResStartDate, R.ResEndDate, T.RentPrice, T.Deposit, CLP.FirstName as FirstNameP, CLD.FirstName as FirstNameD
                            FROM RESERVATIONS as R 
                            JOIN CONTAIN as CON ON R.ResID=CON.RID
                            JOIN TOOLS as T on T.TOOLID = CON.TID
                            LEFT JOIN CLERKS as CLP on CLP.Login = R.ClerkPickup
                            LEFT JOIN CLERKS as CLD on CLD.login = R.ClerkDropoff
                            WHERE R.CuEmail = '$email'
                     		ORDER BY R.ResStartDate DESC";
$result_history = mysqli_query($dbc, $query_res_history);

// if ($back_to_menu) {
//     session_start();
//     $_SESSION['email'] = $login;
//     /* redirect to the customer main menu page */
//     header('Location: CustMainMenu.php');
//     exit();
// }
mysqli_close($dbc);

?>




<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Customer Profile</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
.buttonsize {
	width: 200px;
}
</style>
</head>
<body>
	<h1>Profile</h1>
	<hr />
	<form action="Profile.php" method="get">
	<table>
		<tr>
			<td align="left">Email Address (Login)</td>
			<td><label for="email"><?php print $row_cu['Email'] ?></label></td>
		</tr>
		<tr>
			<td align="left">Name</td>
			<td><label for="name"><?php echo $row_cu['FirstName'],  " ",  $row_cu['LastName'] ?></label></td>
		</tr>
		<tr>
			<td align="left">Home Phone</td>
			<td><label for="home_phone"><?php echo $row_cu['CountryCodeH'],  "-",  $row_cu['LocalNumH'] ?></label></td>
		</tr>
		<tr>
			<td align="left">Work Phone</td>
			<td><label for="work_phone"><?php echo $row_cu['CountryCodeW'],  "-",  $row_cu['LocalNumW'] ?> </label></td>
		</tr>
		<tr>
			<td align="left">Address</td>
			<td><label for="address"><?php echo $row_cu['Address'] ?> </label></td>
		</tr>
                <tr>
                        <td>
                        <button class="buttonsize" id="back" type="button" onClick="location.href='CustMainMenu.html'">Back to Main Menu  </button>

                        </td>		
                        </tr>
	</table>
	<hr />
	<table>
		<tr>
			<td align="left">Reservation History</td>
		</tr>
		<tr>
			<td align="left">********************</td>
		</tr>
                <tr>
			
		</tr>
	</table>
	<table border="1">
	<tr>
	<td>Reservation</td><td>Tools</td><td>Start Date </td><td>End Date </td><td>Rental Price </td><td>Deposit</td><td>PickUp Clerk</td><td>DropOff Clerk</td>
	</tr>
		<tr>
			<td align="left">
                            <?PHP 
                            if ($result_history){
                                
                            while ($row_h = mysqli_fetch_row($result_history)){
                            // Output the data table row by row..
                                echo "\t<tr><td>".$row_h[0]."</td><td>".$row_h[1]."</td><td>".$row_h[2]."</td>
                                         <td>".$row_h[3]."</td><td>"."$".$row_h[4]."</td><td>"."$".$row_h[5]."</td>
                                         <td>".$row_h[6]."</td><td>".$row_h[7]."</td></tr>\n";
                                   }  
                            }
                            
                            ?></td>
                        
		</tr>
	</table>
	</form>
</body>
</html>