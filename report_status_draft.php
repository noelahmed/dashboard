<?php
if(isset($_POST['status'])){
    $status = $_POST['status'];
    switch ($status) {
        case 'SKYBANKING':
            
?>
<?php
    //Connect to database
    $dbc = mysqli_connect("192.168.5.80", "queryuser", "queryuser1", "skybanklive") or die("error connecting to database");
if (!$dbc) {
    die("The SKY BANKING Server is Unexpectedly Closed: " . mysqli_connect_error());
}
$filename = "SKYBANKING_FILE";  
    //Create query to fetch the records
	
	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
    $result = mysqli_query($dbc,"SELECT  T.tt 'YEAR',T.MONTH 'MONTH',T.ll 'MONTH_NUMBER',
SUM(T.total) 'Transactions_Number',  SUM(T.am) 'Transactions_amount' FROM (
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,
MONTH(creationDtTm) ll,SUM(amount) am,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH
 FROM apps_bill_pay a WHERE a.isSuccess='Y' AND DATE(a.creationDtTm ) BETWEEN '$datepicker' AND '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
UNION ALL
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,MONTH(creationDtTm) ll,SUM(amount) am,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH
 FROM apps_transaction a WHERE a.isSuccess='Y' AND a.trnType IN ('06','07','08') AND DATE(a.creationDtTm ) BETWEEN '$datepicker' AND '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
) T
GROUP BY T.tt,T.MONTH
ORDER BY T.tt,T.ll ASC");

   $file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of mysqli fields



	for ($i = 0; $i < mysqli_num_fields($result); $i++) {

	while ($property = mysqli_fetch_field($result)) {
    echo $property->name . "\t";
	}
	}

print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($result))
    {
	
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {
		
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
				
        }
		
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    } 
    
?>
<?php
          
		    break;
       case 'INTERNETBANKING':?>
	   
   

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
$filename = "SKYBANKING_FILE";  
    //Create query to fetch the records
	
	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
    $result = mysqli_query($connect,"select idfcatref,txtreason,datauthorization from fcdbadminebl.admintxnunauthdata a where a.txnid='BPA'
and codstatus='4'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a)");

   $file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of mysqli fields



	for ($i = 0; $i < mysqli_num_fields($result); $i++) {

	while ($property = mysqli_fetch_field($result)) {
    echo $property->name . "\t";
	}
	}

print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($result))
    {
	
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {
		
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
				
        }
		
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    } 
    
?>
<?php
	    break;
        default:
            echo 'NO Channel Selected';
            break;
    }
}
?>
