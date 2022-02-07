    <?php
	ini_set('display_errors', 0);
			 $serverName = "192.168.225.196";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "DB_CARDS";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo); 

	date_default_timezone_set('Asia/Dhaka');

	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	//print_r($_REQUEST);
	

	
	
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); 
	require_once "excel/PHPExcel.php"; 
	$filename ="download/".FRAUD_ALERT_.date("Y_m_d_H_i_s").".xls";
	$objPHPExcel = new PHPExcel();	

	

	 $sql_view = "select distinct DATEPART(year, EntryDateTime) YEAR,
DATENAME(mm, EntryDateTime) MONTH_NAME,
DATEPART(month, EntryDateTime) MONTH_NUMBER,
 count(*) MobileNo
from FA_CALL_LOG
		where CAST(EntryDateTime AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, EntryDateTime),DATEPART(month, EntryDateTime),DATENAME(mm, EntryDateTime)
ORDER BY DATEPART(year, EntryDateTime),DATEPART(month, EntryDateTime)";
$result = sqlsrv_query($conn,$sql_view);
	header('Content-type: application/vnd.ms-excel');		
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');		
		
					$row1=1;
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row1, 'YEAR', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row1, 'MONTH', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row1, 'Transactions Number', PHPExcel_Cell_DataType::TYPE_STRING);
			

					$row=2;
					while(sqlsrv_fetch($result)===true)
					{		
						
							$TXN = sqlsrv_get_field($result,0);
							$LTX = sqlsrv_get_field($result,1);
							$LTX1 = sqlsrv_get_field($result,3);
						
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row, $TXN, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row, $LTX, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row, $LTX1, PHPExcel_Cell_DataType::TYPE_STRING);
					
							
							$row++;	
					}
				
		
			
				if($row>1)
				{
						
					
						$objPHPExcel->getActiveSheet()->setTitle('REPORT');
						$objPHPExcel->setActiveSheetIndex(0);
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						ob_end_clean();
						$objWriter->save(str_replace('.php', '.xls', $filename));
						$objWriter->save('php://output');
						
				}
				else
				{
					
				}
		
	


	

?>