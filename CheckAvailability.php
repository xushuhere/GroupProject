<?php
/* connect to database */
// session_start();
// $host=$_SESSION['host'];
// $user=$_SESSION['dbuser'];
// $pass=$_SESSION['dbpass'];
// $db=$_SESSION['dbname'];

// $dbc = mysqli_connect ( $host,$user,$pass,$db );
// if (!$dbc) {
// 	die("Cound not connect to database");
// }



// if (empty($_POST['start_date']) or empty($_POST['end_date']) ) {
// 		$errorMsg = "Please provide an valid start/end date.";		
// 	}
        
        
// elseif (empty($_POST['tooltype'])) {
//             $errorMsg = "Please select the type of tools you would like to check out.";		
// 	}
// else {  	/* check tool availability  */
// 			session_start();
// 			$_SESSION['email'] = $email;
//                         $_SESSION['Start_data'] = $start_date;
//                         $_SESSION['End_Date'] = $end_date;
//                         $_SESSION['ToolType'] = $tooltype;
// 			/* redirect to the check tool availability page */
// 			header('Location: ToolAvailability.php');

// 			exit();
// 		}
// mysqli_close($dbc);		
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Check Availability</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
	<h2>Select Tool Catalog</h2>
	<hr />
        <form action="ToolAvailability.php" method="post">
		<table>
			<tr>
				<td align="left"><input type="radio" name="tooltype"
					value="hand"> Hand Tool</td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="tooltype"
					value="construction"> Construction Equipment</td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="tooltype"
					value="power"> Power Tool</td>
			</tr>
		</table>
		<hr />
		<table>
		<tr>
				<td align="left">Start Date</td>
				<td><input name="start_date" type="date"></td>
			</tr>
			<tr>
				<td align="left">End Date</td>
				<td><input name="end_date" type="date"></td>
			</tr>
			<tr>
				<td align="left"><input id="submit" type="submit" value="Submit"></td>
			</tr>
		</table>
		
	</form>
	

</body>
</html>