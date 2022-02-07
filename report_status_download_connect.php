    <?php
	ini_set('display_errors', 0);
		include "func_mysql.php";
		include "conn_connect.php";
 //error_reporting(E_ALL);
	 

	date_default_timezone_set('Asia/Dhaka');

	$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	//print_r($_REQUEST);
	

	
	
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); 
	require_once "excel/PHPExcel.php"; 
	$filename ="download/".CONNECT_FILE_.date("Y_m_d_H_i_s").".xls";
	$objPHPExcel = new PHPExcel();	

	

	 $sql_view = "SELECT DISTINCT 
	 	YEAR(processed_time ) 'YEAR',IFNULL(ELT(FIELD(MONTH(processed_time),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS 'MONTH',
 COUNT(ref_no) 'Transactions_Number',SUM(AMOUNT) 'Transactions_amount'
FROM eblconnect_lot_info_detail 
WHERE processed_success='Y'
AND DATE(processed_time ) BETWEEN '$datepicker' AND '$datepicker1'
GROUP BY MONTH(processed_time),YEAR(processed_time )
ORDER BY processed_time ASC";
$result = mysqli_query($connect,$sql_view);
$count=mysqli_num_rows($result);

//echo $count;
	

				
			header('Content-type: application/vnd.ms-excel');		
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');		
		
					$row1=1;
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row1, 'YEAR', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row1, 'MONTH', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row1, 'Transactions Number', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$row1, 'Transactions Amount', PHPExcel_Cell_DataType::TYPE_STRING);

					$row=2;
					for($i=0;$i<$count;$i++)
					{		
						
							$YEAR 		= mysqli_result($result,$i,'YEAR');
							$MONTH 			= mysqli_result($result,$i,'MONTH');
							$Transactions_Number 	= mysqli_result($result,$i,'Transactions_Number');
							$Transactions_amount		=mysqli_result($result,$i,'Transactions_amount');
							
							
							
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row, $YEAR, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row, $MONTH, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row, $Transactions_Number, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$row, $Transactions_amount, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
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