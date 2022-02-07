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
include('conn_otp.php');
?> 

			
			
		
		
	
    <?php
        //echo "Watch the page reload itself in 10 second!";
		$value = $_REQUEST['value'];
	
	$sql = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='ACCOUNT' 
and to_char(trunc(dates),'MON')=UPPER('$value')
and error_response='Successful'";
$sql1 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='ACCOUNT' 
and to_char(trunc(dates),'MON')=UPPER('$value')
";
$sql2 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='CARD' 
and to_char(trunc(dates),'MON')=UPPER('$value')
and error_response='Successful'";
$sql3 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='CARD' 
and to_char(trunc(dates),'MON')=UPPER('$value')
"; 

//decline
$sql4 = "select count(*) TXN4
from ecare.totp where service_type='ACCOUNT' 
and to_char(trunc(dates),'MON')=UPPER('$value')
and error_response='Unsuccessful'";
$sql5 = "select count(*) TXN5
from ecare.totp where service_type='CARD' 
and to_char(trunc(dates),'MON')=UPPER('$value')
and error_response='Unsuccessful'";




$stid = oci_parse($connect, $sql);
$stid1 = oci_parse($connect, $sql1);
$stid2 = oci_parse($connect, $sql2);
$stid3 = oci_parse($connect, $sql3);
$stid4 = oci_parse($connect, $sql4);
$stid5 = oci_parse($connect, $sql5);



oci_execute($stid);
oci_execute($stid1);
oci_execute($stid2);
oci_execute($stid3);
oci_execute($stid4);
oci_execute($stid5);


while (oci_fetch($stid1)) {?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">OTP GENERATED</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Hits</td></font>
			
			
			
			</tr><tr>
			<td>ACCESS FOR ACCOUNT</td>
			<td>
   <?php echo oci_result($stid1, 'TXN') . "<br>\n";
   }
   ?>
</td>



</tr>
<!--CARD OTP-------------------------------------------------------------------->
<?php
while (oci_fetch($stid3)) {?>
<tr>
			<td>ACCESS FOR CARD</td>
			<td>
   <?php echo oci_result($stid3, 'TXN') . "<br>\n";
   
    $_SESSION['DIACDOTP']=oci_result($stid3, 'TXN');
   ?>
</td>
<?php 
}
?>
</td>


</tr>



<?php
oci_free_statement($stid);
oci_free_statement($stid1);
oci_free_statement($stid2);
oci_free_statement($stid3);
oci_close($connect);
		
    ?>
	</tr>
	
	</table>

    </body>
</html>
<?php include "total_dia_bar.php";?>