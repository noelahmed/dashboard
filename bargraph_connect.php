<?php
    //Connect to database
    $dbc = mysqli_connect("192.168.225.36", "dashboard", "dashboard", "eblconnect") or die("error connecting to database");

    //Create query to fetch the records
	
	$currentDateTime = date('Y');
    $query = "SELECT DISTINCT IFNULL(ELT(FIELD(MONTH(processed_time),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH,YEAR(processed_time ) YEAR,
 COUNT(ref_no) TXN
FROM eblconnect_lot_info_detail 
WHERE processed_success='Y'
AND YEAR(processed_time )='2019'
GROUP BY MONTH(processed_time),YEAR(processed_time )
ORDER BY processed_time ASC";

    //Execute the query
    $visitors = mysqli_query($dbc, $query) or die("error executing the query");

    //Create an array to hold the records
    $records = array();

    //Retrive the records and add it to the array
    while($row  = mysqli_fetch_assoc($visitors)){
        $records[] = $row;
    }

    print(json_encode($records));

    //Clean up
    mysqli_free_result($visitors);

    //Close connection
    mysqli_close($dbc);
    
?>
