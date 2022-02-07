<?php
    //Connect to database
	 $serverName = "192.168.2.10,1449";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "AscendMiscallService";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    
$currentDateTime = date('Y');

    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}

$sql = "select distinct  count(*) TXN1,LEFT(DATENAME(mm, ReceiveDate),3) MONTHS,

DATEPART(year, ReceiveDate) YEAR,

DATEPART(month, ReceiveDate) MONTH_NUMBER

from MiscallReceiveLog
		where DATEPART(year, ReceiveDate)=$currentDateTime
GROUP BY DATEPART(year, ReceiveDate),DATEPART(month, ReceiveDate),DATENAME(mm, ReceiveDate)
ORDER BY DATEPART(year, ReceiveDate),DATEPART(month, ReceiveDate)";




    //Execute the query
	$visitors = sqlsrv_query($conn, $sql);
	
    

    //Create an array to hold the records
    $records = array();

    //Retrive the records and add it to the array
    while($row=sqlsrv_fetch_array($visitors))
		{


		$records[] = $row;
   
	
		}

    //Clean up
   
print(json_encode($records));


    //Close connection
   sqlsrv_close($conn);
    
?>