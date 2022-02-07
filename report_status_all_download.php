    <?php
	ini_set('display_errors', 0);
		include "func_mysql.php";
		include "conn_skb.php";
		
	 $DB_USER_NAME = 'queryuser';
$DB_PASSWORD  = 'queryuser';

$connect1 = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.25.165)(PORT = 1522))
    (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.25.166)(PORT = 1522))
    (LOAD_BALANCE = yes)
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = FCDBDB)
    )
  )');
  
  $DBHOST = '192.168.225.36';
$DB_USER_NAME = 'dashboard';
$DB_PASSWORD = 'dashboard';
$DB_NAME = 'eblconnect';

$connect2=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");

$DB_USER_NAME = 'PWRQRY';
$DB_PASSWORD  = 'PWRQRY';

$connect3 = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION = 
     (ADDRESS_LIST = 
       (ADDRESS = (PROTOCOL = TCP)(HOST = 10.251.251.22)(PORT = 1521)) 
     ) 
     (CONNECT_DATA = 
       (SERVICE_NAME = pcard) 
     ) 
   )');


$DB_USER_NAME = 'EBLSMS';
$DB_PASSWORD  = 'EBLSMS';

$connect4 = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.3.88)(PORT = 1529))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = eblcarddb)
    )
  )');


$DBHOST = '192.168.225.36';
$DB_USER_NAME = 'dashboard';
$DB_PASSWORD = 'dashboard';
$DB_NAME = 'remitupload';

$connect5=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");


$serverName = "192.168.2.10,1449";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "AscendMiscallService";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);

 $serverName = "192.168.225.196";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "DB_CARDS";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn7 = sqlsrv_connect( $serverName, $connectionInfo); 
 //error_reporting(E_ALL);
	 
	
	
	date_default_timezone_set('Asia/Dhaka');

	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	//print_r($_REQUEST);
	

	
	
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); 
	require_once "excel/PHPExcel.php"; 
	$filename ="download/".ALL_CHANNEL_FILE_.date("Y_m_d_H_i_s").".xls";
	$objPHPExcel = new PHPExcel();	

	

	 $sql_view = "SELECT  T.tt YEAR,
SUM(T.total),  SUM(T.am)  FROM (
SELECT YEAR(a.creationDtTm ) tt,IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH,COUNT(a.trnReference) total,SUM(amount) am,
MONTH(creationDtTm) ll
 FROM apps_bill_pay a WHERE a.isSuccess='Y' AND DATE(a.creationDtTm ) BETWEEN '$datepicker' and '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
UNION ALL
SELECT YEAR(a.creationDtTm ) tt,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH,COUNT(a.trnReference) total,SUM(amount) am,
 MONTH(creationDtTm) ll
 FROM apps_transaction a WHERE a.isSuccess='Y' AND a.trnType IN ('06','07','08') AND DATE(a.creationDtTm ) 
 BETWEEN '$datepicker' and '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
) T
GROUP BY T.tt
ORDER BY T.tt ASC";


$result = mysqli_query($connect,$sql_view);
$count=mysqli_num_rows($result);




 $sql_view1 = "select distinct EXTRACT(year FROM a.datauthorization) years,count(idfcatref) TXN1,
	sum(a.numamount) AMT
 
     from fcdbadminebl.admintxnunauthdata a where a.txnid in ('BPA','OAT','ITG','BDT')
and  to_char(a.datauthorization, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
and codstatus='5'
GROUP BY EXTRACT(year FROM a.datauthorization)
order by EXTRACT(year FROM a.datauthorization) asc";
$statement_view1=@OCIParse($connect1,$sql_view1);

//echo $count;
$sql_view2 = "SELECT DISTINCT 
	 	YEAR(processed_time ) 'YEAR',
 COUNT(ref_no) 'Transactions_Number',SUM(AMOUNT) 'Transactions_amount'
FROM eblconnect_lot_info_detail 
WHERE processed_success='Y'
AND DATE(processed_time ) BETWEEN '$datepicker' AND '$datepicker1'
GROUP BY YEAR(processed_time )
ORDER BY processed_time ASC";
$result2 = mysqli_query($connect2,$sql_view2);
$count2=mysqli_num_rows($result2);	
//echo $count2;

$sql_view3 = "select distinct EXTRACT(year FROM dates) years,
count(*) TXN
from ecare.totp where service_type in ('ACCOUNT','CARD' ) 
and to_char(dates, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
and error_response='Successful'
GROUP BY EXTRACT(year FROM dates)
order by EXTRACT(year FROM dates)";
$statement_view3=@OCIParse($connect3,$sql_view3);

 $sql_view4 = "SELECT  EXTRACT(year FROM sms_time) years,count(*) TXN1
  FROM sms_message_history  where 
   to_char(sms_time, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
  and ssl_status_desc='SUCCESS'
GROUP BY EXTRACT(year FROM sms_time)
order by EXTRACT(year FROM sms_time) asc";
$statement_view4=@OCIParse($connect4,$sql_view4);


$sql_view5 = "SELECT YEAR(upload_time ) YEAR,
	   COUNT(tt_reference_no) Transactions_Number,SUM(amount) Transactions_amount

FROM remitupload_lot_no_info_detail WHERE  download_status='Y'
AND DATE(upload_time ) BETWEEN '$datepicker' AND '$datepicker1'
GROUP BY YEAR
ORDER BY YEAR ASC";
$result5 = mysqli_query($connect5,$sql_view5);
$count5=mysqli_num_rows($result5);

$sql_view6 = "select distinct DATEPART(year, ReceiveDate) YEAR,
 count(*) MobileNo
from MiscallReceiveLog
		where CAST(ReceiveDate AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, ReceiveDate)
ORDER BY DATEPART(year, ReceiveDate) asc";
$result6 = sqlsrv_query($conn,$sql_view6);

 $sql_view7 = "select distinct DATEPART(year, EntryDateTime) YEAR,
 count(*) MobileNo
from FA_CALL_LOG
		where CAST(EntryDateTime AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, EntryDateTime)
ORDER BY DATEPART(year, EntryDateTime)";
$result7 = sqlsrv_query($conn7,$sql_view7);
				
			header('Content-type: application/vnd.ms-excel');		
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');		
		
					$row1=1;
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row1, 'YEAR', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row1, 'Transactions Number', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row1, 'Transactions Amount', PHPExcel_Cell_DataType::TYPE_STRING);

					$row=2;
					for($i=0;$i<$count;$i++)
					{		
						
							$YEAR 		= mysqli_result($result,$i,'YEAR');
							
							$Transactions_Number 	= mysqli_result($result,$i,'SUM(T.total)');
							$Transactions_amount		=mysqli_result($result,$i,'SUM(T.am)');
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row, $YEAR, PHPExcel_Cell_DataType::TYPE_STRING);
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row, $Transactions_Number, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row, $Transactions_amount, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
							$row++;	
					}
				
				
				 if(@OCIExecute($statement_view1,OCI_DEFAULT) && $statement_view1)            
                { 
					
					$new_row=$row;
					while(OCIFetch($statement_view1))
					{		
						
							$YEARS1 		= ociresult($statement_view1,'YEARS');
							$TXN2 		= ociresult($statement_view1,'TXN1');
							$AMT2		=ociresult($statement_view1,'AMT');
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$new_row, $YEARS1, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$new_row, $TXN2, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$new_row, $AMT2, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
							$new_row++;	
					}
				}
			
				$row2=$new_row;
					for($i=0;$i<$count2;$i++)
					{		
						
							$YEAR2 		= mysqli_result($result2,$i,'YEAR');
							$Transactions_Number2 	= mysqli_result($result2,$i,'Transactions_Number');
							$Transactions_amount2		=mysqli_result($result2,$i,'Transactions_amount');
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row2, $YEAR2, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row2, $Transactions_Number2, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row2, $Transactions_amount2, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
							$row2++;	
					}	
					
				if(@OCIExecute($statement_view3,OCI_DEFAULT) && $statement_view3)            
                { 
					
					$row3=$row2;
					while(OCIFetch($statement_view3))
					{		
						
							$YEARS3 		= ociresult($statement_view3,'YEARS');
							$TXN3 		= ociresult($statement_view3,'TXN');
							
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row3, $YEARS3, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row3, $TXN3, PHPExcel_Cell_DataType::TYPE_STRING);
					
							
							
							$row3++;	
					}
				}
				
				if(@OCIExecute($statement_view4,OCI_DEFAULT) && $statement_view4)            
                { 
				
					$row4=$row3;
					while(OCIFetch($statement_view4))
					{		
						
							$YEARS4 		= ociresult($statement_view4,'YEARS');
					
							$TXN4 		= ociresult($statement_view4,'TXN1');
						
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row4, $YEARS4, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row4, $TXN4, PHPExcel_Cell_DataType::TYPE_STRING);
						
							
							
							$row4++;	
					}
				}
				
				$row5=$row4;
					for($i=0;$i<$count5;$i++)
					{		
						
							$YEAR5 		= mysqli_result($result5,$i,'YEAR');
			
							$Transactions_Number5 	= mysqli_result($result5,$i,'Transactions_Number');
							$Transactions_amount5		=mysqli_result($result5,$i,'Transactions_amount');
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row5, $YEAR5, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row5, $Transactions_Number5, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row5, $Transactions_amount5, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
							$row5++;	
					}
				
				$row6=$row5;
				while(sqlsrv_fetch($result6)===true)
					{		
						
							$TXN = sqlsrv_get_field($result6,0);
							$LTX = sqlsrv_get_field($result6,1);
							
						
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row6, $TXN, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row6, $LTX, PHPExcel_Cell_DataType::TYPE_STRING);
				
					
							
							$row6++;	
					}
				$row7=$row6;
					while(sqlsrv_fetch($result7)===true)
					{		
						
							$TXN = sqlsrv_get_field($result7,0);
							$LTX = sqlsrv_get_field($result7,1);
						
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row7, $TXN, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row7, $LTX, PHPExcel_Cell_DataType::TYPE_STRING);
						
					
							
							$row7++;	
					}
						$objPHPExcel->getActiveSheet()->setTitle('REPORT');
						$objPHPExcel->setActiveSheetIndex(0);
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						ob_end_clean();
						$objWriter->save(str_replace('.php', '.xls', $filename));
						$objWriter->save('php://output');
						
				
		
	

	

	

?>
    