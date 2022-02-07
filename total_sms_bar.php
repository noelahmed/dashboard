
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
		$value = $_REQUEST['value'];
		$currentDateTime = date('Y');
	
	$sql = "select distinct count(*) TXN1,to_char(trunc(sms_time),'MON') MONTHS,
EXTRACT(year FROM sms_time) years
 from sms_message_history
where EXTRACT(year FROM sms_time)=$currentDateTime
and to_char(trunc(sms_time),'MON')=UPPER('$value')
  and ssl_status_desc='SUCCESS'
  GROUP BY EXTRACT(year FROM sms_time),to_char(trunc(sms_time),'MON')";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);


while (oci_fetch($stid)) {?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">SMS</tr><tr></h2>
			
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Transactions</td></font>
			
	
			

			</tr><tr>
			
			<td>
   <?php echo oci_result($stid, 'TXN1') . "<br>\n";
 
   
   }
   ?>
</td>



</tr>
<?php
oci_free_statement($stid);

oci_close($connect);
		
    ?>
	</tr>
	
	</table>

    </body>
</html>
