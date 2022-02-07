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
	$serverName = "192.168.2.10,1449";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "AscendMiscallService";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    

    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}
        //echo "Watch the page reload itself in 10 second!";
		$value = $_REQUEST['value'];
		$currentDateTime = date('Y');
	
	$sql = "select distinct  count(*) TXN1,LEFT(DATENAME(mm, ReceiveDate),3) MONTHS,

DATEPART(year, ReceiveDate) YEAR,

DATEPART(month, ReceiveDate) MONTH_NUMBER

from MiscallReceiveLog
		where DATEPART(year, ReceiveDate)='$currentDateTime'
		and LEFT(DATENAME(mm, ReceiveDate),3)='$value'
GROUP BY DATEPART(year, ReceiveDate),DATEPART(month, ReceiveDate),DATENAME(mm, ReceiveDate)
ORDER BY DATEPART(year, ReceiveDate),DATEPART(month, ReceiveDate)";

	$sql1 = "
select distinct  count(*) TXN1,LEFT(DATENAME(mm, RegistrationDate),3) MONTHS,

DATEPART(year, RegistrationDate) YEAR,

DATEPART(month, RegistrationDate) MONTH_NUMBER

from MiscallServiceCustomerRegistration
		where DATEPART(year, RegistrationDate)=$currentDateTime
		and LEFT(DATENAME(mm, RegistrationDate),3)='$value'
GROUP BY DATEPART(year, RegistrationDate),DATEPART(month, RegistrationDate),DATENAME(mm, RegistrationDate)
ORDER BY DATEPART(year, RegistrationDate),DATEPART(month, RegistrationDate)";



$stmt = sqlsrv_query($conn,$sql);
$stmt1 = sqlsrv_query($conn,$sql1);


if(sqlsrv_fetch($stmt) ===false)
{
    echo "couldn't fetch data"; 
}

else if(sqlsrv_fetch($stmt1) ===false)
{
    echo "couldn't fetch data"; 
}
$TXN = sqlsrv_get_field($stmt,0);
$TXN1 = sqlsrv_get_field($stmt1,0);




?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">MISS CALL ALERT</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Miss Call</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of registered Customers</td></font>
			
			
			
			</tr><tr>
			
			<TD align="CENTER">	

  
	
	
	
	<font size="-1">	
   <?php echo $TXN; ?></font></a>
</td>
	<td>

		
	
	<font size="-1">	  <?php echo $TXN1; ?></font></a>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>
	
	</table>

    </body>
</html>
