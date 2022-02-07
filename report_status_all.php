<html>
    <head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
    </head>
    <body>
	
			

		
	
    <?php
	
	 $connect = mysqli_connect("192.168.5.80", "queryuser", "queryuser1", "skybanklive") or die("error connecting to database");
if (!$connect) {
    die("The SKY BANKING Server is Unexpectedly Closed: " . mysqli_connect_error());
}
        //echo "Watch the page reload itself in 10 second!";
		$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];

	 $query = mysqli_query($connect,"SELECT  T.tt 'YEAR',
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
GROUP BY T.tt
ORDER BY T.tt ASC");
 
?>
		
	<table border=1 width="30%" id="customers">
	
		<tr><TD><h2 align="center">DIGITAL CHANNEL TRANSACTIONS</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> FROM DATE </td> <TD> <?php echo $datepicker ?></TD></tr>
		<tr align="right"> <td> TO DATE </td> <TD> <?php echo $datepicker1 ?></TD></tr>
		<tr>
		<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">DIGITAL CHANNEL </td>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Year</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. Of Succesful Transactions</td>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount Of Succesful Transactions</td>
			</font>
		
		
			</tr>
			<?php
			while($row=mysqli_fetch_array($query))
		{?>
   
			<tr>
				<td>
   SKY BANKING
</td>
			<td>
   <?php  echo $row['YEAR']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   
   ?>
</td>


		<td>

						
						 <?php echo $row['Transactions_Number']; ?>
</td>
<td>

						
						 <?php echo $row['Transactions_amount']; ?>
</td>
</tr>

<?php
}
		
    ?>
<?php
       
	
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
  
  $datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	
	$sql = "select distinct count(idfcatref) TXN1,sum(a.numamount) AMT,
EXTRACT(year FROM a.datauthorization) years  
     from fcdbadminebl.admintxnunauthdata a where a.txnid in ('BPA','OAT','ITG','BDT')
and  to_char(a.datauthorization, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
and codstatus='5'
GROUP BY EXTRACT(year FROM a.datauthorization)
order by EXTRACT(year FROM a.datauthorization) asc";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);

?>
<?php
			while (oci_fetch($stid)) {?>
			<tr>
			<td>
   INTERNET BANKING
</td>
			<td>
   <?php  echo oci_result($stid, 'YEARS') . "<br>\n";
  
   ?>
</td>
<td>
   <?php echo oci_result($stid, 'TXN1') . "<br>\n";?>
</td>
<td>
   <?php echo oci_result($stid, 'AMT') . "<br>\n";?>
</td>


   <?php 
}?>


<?php
oci_free_statement($stid);
oci_close($connect);
		
    ?>
 <?php
	
	 $connect = mysqli_connect("192.168.225.36", "dashboard", "dashboard", "eblconnect") or die("error connecting to database");
if (!$connect) {
    die("The CONNECT is Unexpectedly Closed: " . mysqli_connect_error());
}
        //echo "Watch the page reload itself in 10 second!";
		$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];

	 $query = mysqli_query($connect,"SELECT DISTINCT 
	 	YEAR(processed_time ) 'YEAR',
 COUNT(ref_no) 'Transactions_Number',SUM(AMOUNT) 'Transactions_amount'
FROM eblconnect_lot_info_detail 
WHERE processed_success='Y'
AND DATE(processed_time ) BETWEEN '$datepicker' AND '$datepicker1'
GROUP BY YEAR(processed_time )
ORDER BY processed_time ASC");
 
?>
<?php
			while($row=mysqli_fetch_array($query))
		{?>
   
			<tr>
			<td>
   EBL CONNECT
</td>
			<td>
   <?php  echo $row['YEAR']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   
   ?>
</td>




		<td>

						
						 <?php echo $row['Transactions_Number']; ?>
</td>
<td>

						
						 <?php echo $row['Transactions_amount']; ?>
</td>
</tr>

<?php
}
		
    ?>	
 <?php
       
	
	$DB_USER_NAME = 'PWRQRY';
$DB_PASSWORD  = 'PWRQRY';

$connect = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION = 
     (ADDRESS_LIST = 
       (ADDRESS = (PROTOCOL = TCP)(HOST = 10.251.251.22)(PORT = 1521)) 
     ) 
     (CONNECT_DATA = 
       (SERVICE_NAME = pcard) 
     ) 
   )');

if(!$connect) 
{
                $e = oci_error($connect);  
                $log_info = "[AT:".date("Y-m-d H:i:s")."][IP:][ERROR] [RESPONSE:ORACLE DB CONNECTION][EXECUTED BY:".$_SERVER['PHP_SELF']."][REQ METHOD:oci_connect][RESULT:ISSUCCESS=FAILURE][REASON:E008:Oracle Database Connection Error.".$e['message']."];\r\n";

                update_log($log_info);
                die();
}
  
  $datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	
	$sql = "select distinct EXTRACT(year FROM dates) years,
count(*) TXN
from ecare.totp where service_type in ('ACCOUNT','CARD' ) 
and to_char(dates, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
and error_response='Successful'
GROUP BY EXTRACT(year FROM dates)
order by EXTRACT(year FROM dates)";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);

?>
<?php
			while (oci_fetch($stid)) {?>
			<tr>
			<td>
   EBL DIA
</td>
			<td>
   <?php  echo oci_result($stid, 'YEARS') . "<br>\n";
  
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'TXN') . "<br>\n";?>
</td>



   <?php 
}?>


<?php
oci_free_statement($stid);
oci_close($connect);
		
    ?>
	</tr>
 <?php
       
	
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
  
  $datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	
	$sql = "
 SELECT  EXTRACT(year FROM sms_time) years,count(*) TXN1
  FROM sms_message_history  where 
   to_char(sms_time, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
  and ssl_status_desc='SUCCESS'
GROUP BY EXTRACT(year FROM sms_time)
order by EXTRACT(year FROM sms_time) asc
";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);

?>
<?php
			while (oci_fetch($stid)) {?>
			<tr>
			<td>
   EBL SMS
</td>
			<td>
   <?php  echo oci_result($stid, 'YEARS') . "<br>\n";
  
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'TXN1') . "<br>\n";?>
</td>


   <?php 
}?>


<?php
oci_free_statement($stid);
oci_close($connect);
		
    ?>
	</tr>
<?php
	
	 $DBHOST = '192.168.225.36';
$DB_USER_NAME = 'dashboard';
$DB_PASSWORD = 'dashboard';
$DB_NAME = 'remitupload';

$connect=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");
if (!$connect)
  {
  die("EBL Connect database not live " . mysqli_connect_error());
  }
        //echo "Watch the page reload itself in 10 second!";
		$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];

	 $query = mysqli_query($connect,"SELECT COUNT(tt_reference_no) Transactions_Number,YEAR(upload_time ) YEAR,SUM(amount) Transactions_amount
FROM remitupload_lot_no_info_detail WHERE  download_status='Y'
AND DATE(upload_time ) BETWEEN '$datepicker' AND '$datepicker1'
GROUP BY YEAR
ORDER BY YEAR ASC
");
 
?>
<?php
			while($row=mysqli_fetch_array($query))
		{?>
   
			<tr>
			<td>
   EBL REMIT API
</td>
			<td>
   <?php  echo $row['YEAR']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   
   ?>
</td>



		<td>

						
						 <?php echo $row['Transactions_Number']; ?>
</td>
<td>

						
						 <?php echo $row['Transactions_amount']; ?>
</td>
</tr>

<?php
}
		
    ?>
 <?php
	 $serverName = "192.168.2.10,1449";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "AscendMiscallService";   
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    
$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}

$sql = "select distinct DATEPART(year, ReceiveDate) YEAR,
 count(*) MobileNo
from MiscallReceiveLog
		where CAST(ReceiveDate AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, ReceiveDate)
ORDER BY DATEPART(year, ReceiveDate)";
$stmt = sqlsrv_query($conn,$sql);

?>
<?php
while(sqlsrv_fetch($stmt)===true)
		{
$TXN = sqlsrv_get_field($stmt,0);
$LTX = sqlsrv_get_field($stmt,1);

       
	?>


			<?php
			
		?>
   
			<tr>
			<td>
   MISS CALL ALERT
</td>
			<td>
  <?php echo $TXN; ?>
</td>

<td>
  <?php echo $LTX; ?>
</td>


</tr>

<?php
}
		
    ?>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>
<?php
	$serverName = "192.168.225.196";   
$uid = "dashboard";     
$pwd = "dashboard";    
$databaseName = "DB_CARDS";    
   
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    
$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}

$sql = "select distinct DATEPART(year, EntryDateTime) YEAR,

 count(*) MobileNo
from FA_CALL_LOG
		where CAST(EntryDateTime AS date) between '$datepicker' and '$datepicker1'
GROUP BY DATEPART(year, EntryDateTime)
ORDER BY DATEPART(year, EntryDateTime)";
$stmt = sqlsrv_query($conn,$sql);

?>
<?php
while(sqlsrv_fetch($stmt)===true)
		{
$TXN = sqlsrv_get_field($stmt,0);
$LTX = sqlsrv_get_field($stmt,1);

       
	?>


			<?php
			
		?>
   
			<tr>
			<td>
   FRAUD ALERT
</td>
			<td>
  <?php echo $TXN; ?>
</td>
<td>
  <?php echo $LTX; ?>
</td>



</tr>

<?php
}
		
    ?>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>
	</table>
	<form method = "post" action="report_status_all_download.php"  >
						
	<table border=1 width="30%" id="customers" align="center">
	 <TR>
			   <td align="center">
                           
                        <td align="center">
						<INPUT id=NAME size=22 name=datepicker value="<?php echo $datepicker ?>" type="hidden">
		<INPUT id=NAME size=22 name=datepicker1 value="<?php echo $datepicker1 ?>" type="hidden">
                           <input name = "update" type = "submit" 
                              id = "update" value = "Download"  ></td></TR>
                        </td>
						</TR>
						</TABLE>
						
						
		
		
                     
				</FORM>	
    </body>
</html>
