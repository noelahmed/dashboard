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
DECODE(EXTRACT(month FROM dates),1,'Jan',2,'Feb',
3,'Mar',4,'Apr',5,'May',6,'June',7,'July',8,'Aug',
9,'Sep',10,'Oct',11,'Nov',
'Dec') Months, EXTRACT(month FROM dates) month_number,count(*) TXN
from ecare.totp where service_type in ('ACCOUNT','CARD' ) 
and to_char(dates, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
GROUP BY EXTRACT(month FROM dates),EXTRACT(year FROM dates)
order by EXTRACT(year FROM dates),EXTRACT(month FROM dates)";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);

?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><TD><h2>EBL DIA</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> FROM DATE </td> <TD> <?php echo $datepicker ?></TD></tr>
		<tr align="right"> <td> TO DATE </td> <TD> <?php echo $datepicker1 ?></TD></tr>
		<tr>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Year</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Month</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. Of Succesful Transactions</td>

			

			</tr>
			<?php
			while (oci_fetch($stid)) {?>
			<tr>
			
			<td>
   <?php  echo oci_result($stid, 'YEARS') . "<br>\n";
  
   ?>
</td>
<td>
   <?php  echo oci_result($stid, 'MONTHS') . "<br>\n";
  
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
	
	</table>
<form method = "post" action="report_status_download_DIA.php"  >
						
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