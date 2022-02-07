<?php
    //Connect to database
    $dbc = mysqli_connect("192.168.5.80", "queryuser", "queryuser1", "skybanklive") or die("error connecting to database");
if (!$dbc) {
    die("The SKY BANKING Server is Unexpectedly Closed: " . mysqli_connect_error());
}

    //Create query to fetch the records
	
	$currentDateTime = date('Y');
    $query = "select distinct COUNT(*) TXN,YEAR(commDtTm ) tt,
MONTH(commDtTm) ll,
IFNULL(ELT(FIELD(MONTH(commDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH from app_user_activity_log
 where YEAR(commDtTm )=$currentDateTime
 AND actionName = 'login'
GROUP BY MONTH(commDtTm),YEAR(commDtTm )
order by YEAR(commDtTm ),MONTH(commDtTm) asc";

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
