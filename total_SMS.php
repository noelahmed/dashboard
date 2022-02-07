 <?php
include('conn_sms.php');
?> 

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
        //echo "Watch the page reload itself in 10 second!";
		//$currentDateTime = date('d-m-Y');
	
	$sql = "SELECT  count(*) TXN,to_char(max(sms_time),'DD-MON-RRRR HH24:MI:SS AM') LAST_SUCCESFUL_TRANSACTION
  FROM sms_message_daily_log  where trunc(sms_time)=(select trunc(max(sms_time)) from sms_message_daily_log) 
  and ssl_status_desc='SUCCESS'";
 

//decline
$sql4 = "SELECT  count(*) TXN4
  FROM sms_message_daily_log  where trunc(sms_time)=(select trunc(max(sms_time)) from sms_message_daily_log) 
  and ssl_status_desc!='SUCCESS'";




$stid = oci_parse($connect, $sql);

$stid4 = oci_parse($connect, $sql4);



oci_execute($stid);

oci_execute($stid4);


while (oci_fetch($stid)) {?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2>EBL SMS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Approved TXN</td></font>
			
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last successful Transaction</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Decline TXN</td></font>
			
		
			</tr><tr>
			<td>EBL SMS</td>
			<td>
   <?php  oci_result($stid, 'TXN') . "<br>\n";
   echo $_SESSION['CON_SMSTRF']=oci_result($stid, 'TXN');
  
   ?>
</td>


<td>
   <?php echo oci_result($stid, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid4)) {?>
   
	
	
	
			<td>
			  <a href onClick="window.open('decline_SMS.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid4, 'TXN4') . "<br>\n";

}?></a>
</td>

</tr>

<?php
oci_free_statement($stid);
oci_free_statement($stid4);
oci_close($connect);
		
    ?>
	</tr>
	
	</table>
 
    </body>
</html>