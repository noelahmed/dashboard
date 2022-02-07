<?php error_reporting(1);?>
<?php
        //echo "Watch the page reload itself in 10 second!";
		
		$connect = mysqli_connect('192.168.5.80', 'queryuser', 'queryuser1', 'skybanklive');

if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The SKY BANKING Server is Unexpectedly Closed " ?> </font></b>
<?php }
//echo "Connected successfully";


		
		$currentDateTime = date('Y');
		$currentDateTime1 = date('Y-m-d');
	
	$query = mysqli_query($connect,"
	
	
	SELECT  DATE_FORMAT(T.MONTH,'%d-%M-%Y %h:%m:%s') MONTH,
SUM(T.total) TXN FROM (
SELECT COUNT(a.trnReference) total,
max(creationDtTm ) MONTH
 FROM apps_bill_pay a WHERE a.isSuccess='Y' AND YEAR(a.creationDtTm )=$currentDateTime

UNION ALL
SELECT COUNT(a.trnReference) total,max(creationDtTm ) MONTH
 FROM apps_transaction a WHERE a.isSuccess='Y' AND a.trnType IN ('06','07','08') AND YEAR(a.creationDtTm )=$currentDateTime

) T

	
	
	
	
	");
$query2 = mysqli_query($connect,"
	
	
	SELECT  
SUM(T.TXN) TXN FROM (
select count(a.trnReference) TXN,sum(a.amount) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_bill_pay a where a.isSuccess='Y' and DATE(a.creationDtTm )='$currentDateTime1'
UNION ALL
select count(a.trnReference) TXN,sum(a.amount) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_transaction a where a.isSuccess='Y' and DATE(a.creationDtTm )='$currentDateTime1'
) T

	
	
	
	
	");	
 $query1 = mysqli_query($connect,"
	
	
	SELECT  T.tt,T.ll,
SUM(T.total) TXN FROM (
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,
MONTH(creationDtTm) ll,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'January','February','March','April',
       'May','June','July'),
       'August') AS MONTH
 FROM apps_bill_pay a WHERE a.isSuccess='Y' AND YEAR(a.creationDtTm )=$currentDateTime-1
 GROUP BY MONTH(creationDtTm) ASC
UNION ALL
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,MONTH(creationDtTm) ll,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'January','February','March','April',
       'May','June','July'),
       'August') AS MONTH
 FROM apps_transaction a WHERE a.isSuccess='Y' AND a.trnType IN ('06','07','08') AND YEAR(a.creationDtTm )=$currentDateTime-1
 GROUP BY MONTH(creationDtTm) ASC
) T
GROUP BY T.tt
ORDER BY T.ll ASC
	
	
	
	
	");?>

<table border=1 width="100%" id="customers">
	
		<tr>
			<td bgcolor="#009900"><B><font color="#FFFFFF" size="-1">Transaction Channels</td></font>
			<td bgcolor="#009900"><B><font color="#FFFFFF" size="-1">Today's Txn</td></font>
			<td bgcolor="#009900"><B><font color="#FFFFFF" size="-1">Last successful Txn</td></font>

			
		
			</tr><tr>
			<td><font color="#000000" size="-1">SKY BANKING </td></font>
			<TD align="CENTER">	<a href
			onClick="window.open('total_skb_txn.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
 while($row2=mysqli_fetch_array($query2))
		{?>
  
	
	
	
	<font size="-1">	
   <?php echo $row2['TXN']; ?></font></a>
<?php
}
		
    ?></td>
	<td><font color="#000000"><?php

		while($row=mysqli_fetch_array($query))
		{?>
  
	
	<font size="-1">	<?php echo $row['MONTH']; ?>
<?php
}
		
    ?></td></tr>
	
<!--------------------INTERNET BANKING----------------------------------------!>
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

	if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The INTERNET BANKING Server is Unexpectedly Closed " ?> </font></b>
<?php }
	
	$currentDateTime = date('Y');
	
        $sql = "select distinct count(idfcatref) TXN,max(a.datauthorization) Months
     from fcdbadminebl.admintxnunauthdata a where a.txnid in ('BPA','OAT','ITG','BDT')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='5'
";

$sql2 = "select count(*) TXN,sum(a.numamount) AMT,max(a.datauthorization) Last_succesful_transaction
	 from fcdbadminebl.admintxnunauthdata a where
	  trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='5'

";

$sql1 = "select distinct count(idfcatref) TXN,EXTRACT(year FROM a.datauthorization) years  
     from fcdbadminebl.admintxnunauthdata a where a.txnid in ('BPA','OAT','ITG','BDT')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime-1
and codstatus='5'
GROUP BY EXTRACT(year FROM a.datauthorization)
";

	$stid = oci_parse($connect, $sql);
	$stid1 = oci_parse($connect, $sql1);
	$stid2 = oci_parse($connect, $sql2);
	oci_execute($stid);
	oci_execute($stid1);
	oci_execute($stid2);
	
	?>

<tr>
			<td><font color="#000000" size="-1">INTERNET BANKING</td></font>
			<TD align="CENTER">	<a href onClick="window.open('total_ib.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
while (oci_fetch($stid2)) {?>
  
	
	
	
	<font size="-1">	
   <?php echo oci_result($stid2, 'TXN') . "<br>\n";?></font></a>
<?php
}
		
    ?></td>
	<td><font color="#000000"><?php

		while (oci_fetch($stid)) {?>
	
	<font size="-1">	<?php echo oci_result($stid, 'MONTHS') . "<br>\n";?>
<?php
}
		
    ?></td></font>
	
<!--------------------CONNECT----------------------------------------!>
<?php
        //echo "Watch the page reload itself in 10 second!";
		
		$connect = mysqli_connect('192.168.225.36', 'dashboard', 'dashboard', 'eblconnect');

if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The CONNECT Server is Unexpectedly Closed " ?> </font></b>
<?php }


		
		$currentDateTime = date('Y');
	
	$query = mysqli_query($connect,"
	
	
	select count(ref_no) TXN,DATE_FORMAT(max(processed_time ),'%d-%M-%Y %h:%m:%s') MONTH  
from eblconnect_lot_info_detail where processed_success='Y'
and  YEAR(processed_time )=$currentDateTime
	
	
	
	
	");
	$query2 = mysqli_query($connect,"
	
	
		select count(ref_no) TXN,sum(amount) AMT,DATE_FORMAT(max(processed_time ),'%d-%M-%Y %h:%m:%s') Last_succesful_transaction  
		from eblconnect_lot_info_detail where processed_success='Y'
 and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y')
	
	
	
	
	");
	$query1 = mysqli_query($connect,"
	
	
	SELECT DISTINCT YEAR(processed_time ) YEAR,
 COUNT(ref_no) TXN
FROM eblconnect_lot_info_detail 
WHERE processed_success='Y'
AND YEAR(processed_time )=$currentDateTime
GROUP BY YEAR(processed_time )
ORDER BY processed_time ASC
	
	
	
	
	");
 
?>

<tr>
			<td><font color="#000000" size="-1">EBL CONNECT</td></font>
			<TD align="CENTER">	<a href onClick="window.open('total_connect.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
 while($row2=mysqli_fetch_array($query2))
		{?>
  
	
	
	
	<font size="-1">	
   <?php echo $row2['TXN']; ?></font></a>
<?php
}
		
    ?></td>
	<td><font color="#000000"><?php

		while($row=mysqli_fetch_array($query))
		{?>
  
	
	<font size="-1">	<?php echo $row['MONTH']; ?>
<?php
}
		
    ?></td></tr>
<!-------------------------------------DIA------------------------>
<?php
$DB_USER_NAME = 'EBLIBDATA';
$DB_PASSWORD  = 'Eblibdata_123';

$connect = oci_connect("$DB_USER_NAME","$DB_PASSWORD",
'(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=192.168.3.30)
      (PORT=1529)
    )
    (CONNECT_DATA=
      (SERVER=dedicated)
      (SERVICE_NAME=ebladc)
    )
  )');

if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The DIA Server is Unexpectedly Closed " ?> </font></b>
<?php }
	
	
        $sql = "select count(*) TXN,sum(amount) AMT,to_char(max(trn_dt),'DD-MON-RRRR HH24:MI:SS AM') MONTHS
 from mobile_recharge_entry where ft_card_status  in ('000','Y')
and topup_status='S'
and  trunc(trn_dt)=(select trunc(max(trn_dt)) from mobile_recharge_entry)
";


	$stid = oci_parse($connect, $sql);
	
	oci_execute($stid);

	
	?>

<tr>
			<td><font color="#000000" size="-1">ACCESS THROUGH EBL DIA</td></font>
			<TD align="CENTER">	<a href onClick="window.open('index_dia.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
while (oci_fetch($stid)) {?>
  
	
	
	
	<font size="-1">	
   <?php echo oci_result($stid, 'TXN') . "<br>\n";?></font></a>
</td>
	<td><font color="#000000">


	
	<font size="-1">	<?php echo oci_result($stid, 'MONTHS') . "<br>\n";?>
<?php
}
		
    ?></td></font>
<!-------------------------------------SMS------------------------>
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

if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The SMS Server is Unexpectedly Closed " ?> </font></b>
<?php }	
	
	//$currentDateTime = date('Y');
	
	
        $sql = "SELECT  count(*) TXN,to_char(max(sms_time),'DD-MON-RRRR HH24:MI:SS AM') MONTHS
  FROM sms_message_daily_log  where trunc(sms_time)=(select trunc(max(sms_time)) from sms_message_daily_log) 
  and ssl_status_desc='SUCCESS'
";



	$stid = oci_parse($connect, $sql);
	
	oci_execute($stid);
	
	?>

<tr>
			<td><font color="#000000" size="-1">SMS</td></font>
			<TD align="CENTER">	<a href onClick="window.open('total_sms.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
while (oci_fetch($stid)) {?>
  
	
	
	
	<font size="-1">	
   <?php echo oci_result($stid, 'TXN') . "<br>\n";?></font></a>
</td>
	<td><font color="#000000">


	
	<font size="-1">	<?php echo oci_result($stid, 'MONTHS') . "<br>\n";?>
<?php
}
	oci_free_statement($stid);
oci_close($connect);	
    ?></td></font>
<!-------------------------------------REMIT------------------------>
<?php
	 $DBHOST = '192.168.225.36';
$DB_USER_NAME = 'dashboard';
$DB_PASSWORD = 'dashboard';
$DB_NAME = 'remitupload';

$connect=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");
if (!$connect) {?>
    <font color="red" size="+1"> <B> <?php echo "The REMIT API Server is Unexpectedly Closed " ?> </font></b>
<?php }	
	
	
	//$currentDateTime = date('Y');
	
	$query = mysqli_query($connect,"
	
	SELECT COUNT(tt_reference_no) TXN,SUM(amount) AMT,DATE_FORMAT(MAX(upload_time ),'%d-%M-%Y %h:%m:%s') MONTH FROM remitupload_lot_no_info_detail WHERE  download_status='Y'
AND DATE(upload_time )=(SELECT MAX(DATE(upload_time ))  FROM 
remitupload_lot_no_info_detail WHERE  download_status='Y')
	
	
	
	
	");
       
	?>

<tr>
			<td><font color="#000000" size="-1">REMIITANCE</td></font>
			<TD align="CENTER">	<a href onClick="window.open('total_remit.php', 
                         'newwindow1', 
                         'width=800,height=600')" title="click to show details"><?php
 while($row=mysqli_fetch_array($query))
		{?>
  
	
	
	
	<font size="-1">	
   <?php echo $row['TXN']; ?></font></a>
</td>
	<td><font color="#000000">

		
	
	<font size="-1">	<?php echo $row['MONTH']; ?>
<?php
}
		
    ?></td></tr>
<!-------------------------------------MISS CALL------------------------>
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
    

    
if( $conn === false )
{
    echo "failed connection for MISS CALL";
}

$sql = "select count(*) MobileNo,CONVERT(varchar(24),max(ReceiveDate)) MobileNo1 from MiscallReceiveLog
		where CAST(ReceiveDate AS date) = 
(select max(CAST(ReceiveDate AS date) ) 
from MiscallReceiveLog )";
$stmt = sqlsrv_query($conn,$sql);
if(sqlsrv_fetch($stmt) ===false)
{
    echo "couldn't fetch data"; 
}
$TXN = sqlsrv_get_field($stmt,0);
$LTX = sqlsrv_get_field($stmt,1);
       
	?>

<tr>
			<td><font color="#000000" size="-1">MISS CALL ALERT SERVICE</td></font>
			<TD align="CENTER">	

  
	
	
	
	<font size="-1" color="#0099CC">	
   <?php echo $TXN; ?></font></a>
</td>
	<td><font color="#000000">

		
	
	<font size="-1">	 <?php echo $LTX; ?>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>
<!-------------------------------------FRAUD ALERT------------------------>
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
    

    
if( $conn === false )
{
    echo "failed connection for FRAUD ALERT";
}

$sql = "select count(*) MobileNo,CONVERT(varchar(24),max(EntryDateTime)) MobileNo1 from [dbo].[FA_CALL_LOG]
		where CAST(EntryDateTime AS date) = 
(select max(CAST(EntryDateTime AS date) ) 
from [dbo].[FA_CALL_LOG] )";
$stmt = sqlsrv_query($conn,$sql);
if(sqlsrv_fetch($stmt) ===false)
{
    echo "couldn't fetch data"; 
}

$MobileNo = sqlsrv_get_field($stmt,0);
$MobileNo1 = sqlsrv_get_field($stmt,1);


  
  sqlsrv_close( $conn ); 
?>    

<tr>
			<td><font color="#000000" size="-1">FRAUD ALERT SERVICE</td></font>
			<TD align="CENTER">	

  
	
	
	
	<font size="-1" color="#0099CC">	
   <?php echo $MobileNo; ?></font></a>
</td>
	<td><font color="#000000">

		
	
	<font size="-1">	 <?php echo $MobileNo1; ?>
<?php
sqlsrv_close( $conn );  
		
    ?></td></tr>