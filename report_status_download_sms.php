    <?php
	ini_set('display_errors', 0);
		//include "func_mysql.php";
		include "conn_sms.php";
 //error_reporting(E_ALL);
	 
	
	
	date_default_timezone_set('Asia/Dhaka');

	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	//print_r($_REQUEST);
	

	
	
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); 
	require_once "excel/PHPExcel.php"; 
	$filename ="download/".SMS_FILE.date("Y_m_d_H_i_s").".xls";
	$objPHPExcel = new PHPExcel();	

	

	 $sql_view = "SELECT  count(*) TXN1,DECODE(EXTRACT(month FROM sms_time),1,'Jan',2,'Feb',
3,'Mar',4,'Apr',5,'May',6,'June',7,'July',8,'Aug',
9,'Sep',10,'Oct',11,'Nov',
'Dec') MONTHS,EXTRACT(month FROM sms_time) month_number,EXTRACT(year FROM sms_time) YEARS
  FROM sms_message_history  where 
   to_char(sms_time, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
  and ssl_status_desc='SUCCESS'
GROUP BY EXTRACT(month FROM sms_time),EXTRACT(year FROM sms_time)
order by YEARS,month_number asc";
$statement_view=@OCIParse($connect,$sql_view);
//oci_execute($result);


//echo $statement_view;
	 if(@OCIExecute($statement_view,OCI_DEFAULT) && $statement_view)            
                { 
					header('Content-type: application/vnd.ms-excel');		
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');		
		
					$row1=1;
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row1, 'YEAR', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row1, 'MONTH', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row1, 'Transactions Number', PHPExcel_Cell_DataType::TYPE_STRING);
				

					$row=2;
					while(OCIFetch($statement_view))
					{		
						
							$YEARS 		= ociresult($statement_view,'YEARS');
							$MONTHS 	=ociresult($statement_view,'MONTHS'); 
							$TXN1 		= ociresult($statement_view,'TXN1');
						
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row, $YEARS, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row, $MONTHS, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row, $TXN1, PHPExcel_Cell_DataType::TYPE_STRING);
						
							
							
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
		
	
}
	

	

?>