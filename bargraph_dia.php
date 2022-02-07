<?php
    //Connect to database
	include('conn_otp.php');

    //Create query to fetch the records
	
	$currentDateTime = date('Y');
    $strQuery = "select count(*) TXN1,DECODE(EXTRACT(month FROM dates),1,'Jan',2,'Feb',
3,'Mar',4,'Apr',5,'May',6,'June',7,'July',8,'Aug',
9,'Sep',10,'Oct',11,'Nov',
'Dec') Months,
EXTRACT(month FROM dates),EXTRACT(year FROM dates) years
from ecare.totp where  EXTRACT(year FROM dates)='2019'
and error_response='Successful'
GROUP BY EXTRACT(month FROM dates),EXTRACT(year FROM dates)
order by EXTRACT(month FROM dates) asc";

    //Execute the query
	$visitors = oci_parse($connect, $strQuery);
	oci_execute($visitors);	
    

    //Create an array to hold the records
    $records = array();

    //Retrive the records and add it to the array
     while ( $row  = oci_fetch_assoc($visitors)){
        $records[] = $row;
    }

    print(json_encode($records));

    //Clean up
   oci_free_statement($visitors);



    //Close connection
   oci_close($connect);
    
?>