<?php
    //Connect to database
	 $DB_USER_NAME = 'EBLSMS';
$DB_PASSWORD  = 'EBLSMS';

$connect = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.3.88)(PORT = 1529))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = eblcarddb)
    )
  )');

    //Create query to fetch the records
	
	$currentDateTime = date('Y');
    $strQuery = "select distinct count(*) TXN1,to_char(trunc(sms_time),'MON') MONTHS,
EXTRACT(year FROM sms_time) years
 from sms_message_history
where EXTRACT(year FROM sms_time)=$currentDateTime
  and ssl_status_desc='SUCCESS'
  GROUP BY EXTRACT(year FROM sms_time),to_char(trunc(sms_time),'MON')";



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