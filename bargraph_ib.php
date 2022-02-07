<?php
    //Connect to database
	$DB_USER_NAME = 'queryuser';
$DB_PASSWORD  = 'queryuser';
    $connect = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.25.165)(PORT = 1522))
    (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.25.166)(PORT = 1522))
    (LOAD_BALANCE = yes)
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = FCDBDB)
    )
  )');

    //Create query to fetch the records
	
	$currentDateTime = date('Y');
    $strQuery = "select distinct count(*) TXN1,DECODE(EXTRACT(month FROM a.dattxn),1,'Jan',2,'Feb',
3,'Mar',4,'Apr',5,'May',6,'June',7,'July',8,'Aug',
9,'Sep',10,'Oct',11,'Nov',
'Dec') Months,
EXTRACT(month FROM a.dattxn) st,EXTRACT(year FROM a.dattxn) years 
     from auditlog a,msttxn b where a.idtxn = b.idtxn
and EXTRACT(year FROM a.dattxn)=$currentDateTime
AND a.idtxn not in ('BPA','OAT','ITG','BDT')
and b.description='LOGIN'
GROUP BY EXTRACT(month FROM a.dattxn),EXTRACT(year FROM a.dattxn)
order by EXTRACT(year FROM a.dattxn),EXTRACT(month FROM a.dattxn) asc
";

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