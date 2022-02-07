<html>
    <head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
    </head>
    <body>
	
			

		
	
    <?php
	$serverName = "192.168.225.196";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "DB_CARDS";    
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    
$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}

$sql = "select distinct DATEPART(year, EntryDateTime) YEAR,
DATENAME(mm, EntryDateTime) MONTH_NAME,
DATEPART(month, EntryDateTime) MONTH_NUMBER,
 count(*) MobileNo
from FA_CALL_LOG
		where CAST(EntryDateTime AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, EntryDateTime),DATEPART(month, EntryDateTime),DATENAME(mm, EntryDateTime)
ORDER BY DATEPART(year, EntryDateTime),DATEPART(month, EntryDateTime)";
$stmt = sqlsrv_query($conn,$sql);

?>
<table border=1 width="30%" id="customers">
	
		<tr><TD><h2 align="center">FRAUD ALERT</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> FROM DATE </td> <TD> <?php echo $datepicker ?></TD></tr>
		<tr align="right"> <td> TO DATE </td> <TD> <?php echo $datepicker1 ?></TD></tr>
		<tr>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Year</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Month</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. Of Succesful Transactions</td>
			
			</font>
		
		
			</tr>
			<?php
while(sqlsrv_fetch($stmt)===true)
		{
$TXN = sqlsrv_get_field($stmt,0);
$LTX = sqlsrv_get_field($stmt,1);
$LTX1 = sqlsrv_get_field($stmt,3);
       
	?>


			<?php
			
		?>
   
			<tr>
			
			<td>
  <?php echo $TXN; ?>
</td>
<td>
  <?php echo $LTX; ?>
</td>
<td>
  <?php echo $LTX1; ?>
</td>


</tr>

<?php
}
		
    ?>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>
	
	
	</table>
<form method = "post" action="report_status_download_fraud.php"  >
						
	<table border=1 width="30%" id="customers" align="center">
	 <TR>
			   <td align="center">
                           
                        <td align="center">
						<INPUT id=NAME size=22 name=datepicker value="<?php echo $datepicker ?>" type="hidden">
		<INPUT id=NAME size=22 name=datepicker1 value="<?php echo $datepicker1 ?>" type="hidden">
                           <input name = "update" type = "submit" 
                              id = "update" value = "Download"  ></td></TR>
                        </td>
						</TR>
						</TABLE>
						
						
		
		
                     
				</FORM>	
    </body>
</html>
