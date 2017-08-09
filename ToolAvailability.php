<?php
/* connect to database */
session_start();
$host = $_SESSION['host'];
$user = $_SESSION['dbuser'];
$pass = $_SESSION['dbpass'];
$db   = $_SESSION['dbname'];
$tooltype   = $_POST['tooltype'];
$email      = $_SESSION['customer'] ;
$start_date = $_POST['start_date'] ;
$end_date   = $_POST['end_date'] ;

$dbc = mysqli_connect ( $host,$user,$pass,$db );
if (!$dbc) {
	die("Cound not connect to database");
}


                    
$query_tools_av = "SELECT ToolID, AbbrDes, RentPrice, Deposit
                    FROM TOOLS
                    WHERE  ClerkSellTool IS NULL AND ToolType = '$tooltype' AND (ToolID NOT IN (
                        SELECT C.TID
                        FROM RESERVATIONS AS R, CONTAIN AS C
                        WHERE NOT ('$end_date'<=R.ResStartDate OR '$start_date'>=R.ResEndDate)
                                AND R.ResID=C.RID ))
                        AND (ToolID NOT IN
                        (SELECT TID
                        FROM SERVICE_REQUEST
                        WHERE NOT ('$end_date'<=StartDate OR '$start_date'>=EndDate)))";

$tools_av = mysqli_query($dbc,$query_tools_av);

/*
if ($_POST['view_detail']){
    $query_tools_des = "SELECT ToolID, AbbrDes, FullDes, RentPrice, Deposit
                        FROM TOOLS
                        WHERE T.ToolID = $part_num";
    $tools_des = mysqli_query($dbc,$query_tools_des);
    $tool_des_row = mysqli_fetch_array($tools_des);
    echo "\t<tr><td>".$tool_des_row['FullDes']."</td></tr>\n";
    }
    
if ($_POST['back_main']) {   
    session_start();
    $_SESSION['email'] = $email;
    // redirect to the check tool availability page
    header('Location: CustMainMenu.php');
    exit();
}*/
mysqli_close($dbc);
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tool Availability</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}
</style>
</head>
<body>
	<h1>Tool Availability</h1>
        <form action="ToolDetail.php" method="post">
		<table border="1">
	<?PHP 
				echo "\t<tr><td>"."ToolID"."</td><td>"."AbbrDes"."</td><td>"."Deposit"."</td>
                                         <td>"."RentPrice"."</td></tr>\n";
              if ($tools_av){
                //echo "<tr><td>'ToolID'</td><td>'Abbr. Description'</td><td>'Deposit ($)'</td><td>'Price/Day ($)'</td></tr>\n";
                while ($row_t = mysqli_fetch_array($tools_av)){
                            // Output the data table row by row..
                                echo "\t<tr><td>".$row_t['ToolID']."</td><td>".$row_t['AbbrDes']."</td><td>".$row_t['Deposit']."</td>
                                         <td>".$row_t['RentPrice']."</td></tr>\n";
                                   }  
              }
              

              
                            ?>
                   </table>
            	

	<hr />
		<table>
			<tr>
				<td align="left">Part #</td>
				<td><input name="part_num" type="text"></td>
				<td><input id="submit" type="submit" value="View Details"></td>
			</tr>
			<tr>
				<td><button class="buttonsize" id="back_to_main" type="button" onClick="location.href='CustMainMenu.html'">Back to Main </button></td>
			</tr>
		</table>
		</form>
</body>
</html>