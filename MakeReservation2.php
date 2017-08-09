<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Make Reservation</title>
<style>
html, body, table {
	text-align: center;
	margin: 0px auto;
	padding-top: 20px
}

.selectsize {
	width: 180px;
}
</style>
</head>

<?php 
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];
$dbc = mysqli_connect ( $host,$user,$pass,$db );

//$ResStartDate = $_SESSION['ResStartDate'];
$ResStartDate = 1;

$ResEndDate =$_SESSION['ResEndDate'];
$tooltype=array("hand","power","construction");
$sqlhand = "select ToolID,AbbrDes,RentPrice from TOOLS where ToolType='hand'";
$result=mysqli_query($dbc,$sqlhand);
$handtools = array();
while( $row = mysqli_fetch_row($result) )
{
	$handtools[] = "# ".$row[0] ." ". $row[1] . " $" . $row[2];
}
$sqlpower = "select ToolID,AbbrDes,RentPrice from TOOLS where ToolType='power'";
$result1=mysqli_query($dbc,$sqlpower);
$powertools = array();
while( $row1 = mysqli_fetch_array($result1) )
{
	$powertools[] = "# ".$row1[0] ." ". $row1[1] . " $" . $row1[2];
}
$sqlcons = "select ToolID,AbbrDes,RentPrice from TOOLS where ToolType='construction'";
$result2=mysqli_query($dbc,$sqlcons);
$constools = array();
while( $row2 = mysqli_fetch_array($result2) )
{
	$constools[] = "# ".$row2[0] ." ". $row2[1] . " $" . $row2[2];
}
$numhand=count($handtools);
$numpower=count($powertools);
$numcons=count($constools);
mysqli_close($dbc);
?>

           <SCRIPT LANGUAGE=JavaScript>
            
            var aCity=new Array();
            
            aCity[0]=new Array();
            aCity[1]=new Array();
            aCity[2]=new Array();
            aCity[3]=new Array();
            
                        <?php
			for($j=0;$j<$numhand;$j++)
			{
			?>
			aCity[0][<?php echo $j;?>] = new Array("<?php echo '';?>");
			<?php }?> 
                        <?php
			for($j=0;$j<$numhand;$j++)
			{
			?>
			aCity[1][<?php echo $j;?>] = new Array("<?php echo $handtools[$j];?>");
			<?php }?> 
			<?php
			for($i=0;$i<$numpower;$i++)
			{
			?>
			aCity[2][<?php echo $i;?>] = new Array("<?php echo $powertools[$i];?>");
			<?php }?> 
 			<?php
 			for($k=0;$k<$numcons;$k++)
            		{
            		?>
            		aCity[3][<?php echo $k;?>] = "<?php echo $constools[$k];?>";
            		<?php }?> 

            var i = 0,k=2;
            function ChangeTool()
            {

            var i,iProvinceIndex;
            
            iProvinceIndex=document.tool.tooltype.selectedIndex
            iCityCount=0;
            while (aCity[iProvinceIndex][iCityCount]!=null)
            iCityCount++;
            document.tool.tools.length=iCityCount;
            for (i=0;i<=iCityCount-1;i++)
            document.tool.tools[i]=new Option(aCity[iProvinceIndex][i]);
            document.tool.tools.focus()
            }
			
                 
            var oNewRow  ;  
            var oNewCell1,oNewCell2; 
            function AddRow()  
            {  
            i = document.all.toolcontrol.rows.length;  
            oNewRow = document.all.toolcontrol.insertRow(i);  
            oNewRow.id = k;  
            oNewCell1 = document.all.toolcontrol.rows[i].insertCell(0); 
            oNewCell1.innerHTML = k+".<select class='selectsize' id='tooltype"+k+"' name='tooltype' size=1 ONCHANGE=ChangeTool()>"+
			"<option value='hand'>Hand Tools</option>"+
			"<option value='power'>Power Tools</option>"+
			"<option value='construction'>Construction Equipment</option>"+
	        "</select>";
            oNewCell2 = document.all.toolcontrol.rows[i].insertCell(1);
            oNewCell2.innerHTML = "<select class='selectsize' id='addtool"+k+"' name='tools' size=1></select>";

            var selecttype = document.getElementById("tooltype"+k);
            var select = document.getElementById("addtool"+k);
            
            selecttype.onchange=function(){fieldcheck()};
            function fieldcheck() {
                if (selecttype.value == 'hand') {
                	select.options.length = 0;
                    for (var i = 0; i < aCity[0].length; ++i) {
                    	var newOption = document.createElement("option");
                    	newOption.text = aCity[0][i];
                        newOption.value = aCity[0][i];
                        select.appendChild(newOption);
                    }
                } else if(selecttype.value == 'power'){
                	select.options.length = 0;
                    for (var i = 0; i < aCity[1].length; ++i) {
                    	var newOption = document.createElement("option");
                    	newOption.text = aCity[1][i];
                        newOption.value = aCity[1][i];
                        select.appendChild(newOption);
                }
                }
                    else{
                    	select.options.length = 0;
                    	for (var i = 0; i < aCity[2].length; ++i) {
                        	var newOption = document.createElement("option");
                        	newOption.text = aCity[2][i];
                            newOption.value = aCity[2][i];
                            select.appendChild(newOption);
                        }
           	 }
            
            }
			k++;
            j++;
            
            }
            
			
            
            function DelCurrentRow()  
            {  
            with(document.all.toolcontrol)  
            {           
            deleteRow(k-1);  
			k--;
            }  
            }  
            </SCRIPT>


<body id="body" ONFOCUS=ChangeTool()>

	<h1>Make Reservation</h1>
      
		<table>
			<tr>
				<td align="left">Starting Date: </td>
				<td><?php echo $ResStartDate; ?></td>
			</tr>
			<tr>
				<td align="left">Ending Date: </td>
				<td><?php echo $ResEndDate; ?></td>
			</tr>
		</table>
		<br> <br>
           <form name="tool" action="ResSummary.php" method="post">
		<table id="toolcontrol">
			<tr>
				<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Type of Tool</td>
				<td align="left">Tool</td>
			</tr>
			<tr>
				<td>1.<select class="selectsize" id="tooltype" name="tooltype" size=1 ONCHANGE=ChangeTool()>
						<option value="hand">Hand Tools</option>
						<option value="power">Power Tools</option>
						<option value="construction">Construction Equipment</option>
				</select></td>
				<td><select class="selectsize" name="tools" size=1>      
				</select></td>
			</tr>
		</table>
		<br>
		<table>
			<tr>
				<td><button class="selectsize" name="add_more_tools"
						type="button" onClick="AddRow()">Add More Tools</button></td>
				<td><button class="selectsize" name="remove_last_tool"
						type="button" onClick="DelCurrentRow()">Remove Last Tool</button></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td><input id="submit" type="submit" value="Calculate Total"></td>
			</tr>
		</table>
	</form>
</body>
</html>