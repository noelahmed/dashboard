 <?php
include('conn_otp.php');
?> 

			
			
		
		
	
    <?php
        //echo "Watch the page reload itself in 10 second!";
		//$currentDateTime = date('d-m-Y');
	
	$sql = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='ACCOUNT' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
and error_response='Successful'";
$sql1 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='ACCOUNT' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
";
$sql2 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='CARD' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
and error_response='Successful'";
$sql3 = "select count(*) TXN,to_char(max(dates),'DD-MON-RRRR HH24:MI:SS AM') Last_succesful_transaction 
from ecare.totp where service_type='CARD' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
"; 

//decline
$sql4 = "select count(*) TXN4
from ecare.totp where service_type='ACCOUNT' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
and error_response='Unsuccessful'";
$sql5 = "select count(*) TXN5
from ecare.totp where service_type='CARD' 
and trunc(dates)=(select trunc(max(dates)) from ecare.totp)
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
   
	<table border=1 width="40%">
	
		<tr>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Total OTP</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Sucessful OTP</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last successful OTP</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Unsucessful OTP</td></font>
			
			
			</tr><tr>
			<td>ACCESS FOR ACCOUNT</td>
			<td>
   <?php echo oci_result($stid1, 'TXN') . "<br>\n";?>
</td>
<?php }
while (oci_fetch($stid)) {?>
<td>
   <?php echo oci_result($stid, 'TXN') . "<br>\n";
     $_SESSION['DIAOTP']=oci_result($stid, 'TXN');
   
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid4)) {?>
   
	
	
	
			<td>
			  <a href onClick="window.open('decline_CARD_DIA.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid4, 'TXN4') . "<br>\n";

}

?></a>
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
while (oci_fetch($stid2)) {?>
<td>
   <?php echo oci_result($stid2, 'TXN') . "<br>\n";?>
</td>

<td>
   <?php echo oci_result($stid2, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid5)) {?>
   
	
	
	
			<td>
			  <a href onClick="window.open('decline_ACCOUNT_DIA.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid5, 'TXN5') . "<br>\n";

}?></a>
</td>

</tr>



<?php
oci_free_statement($stid);
oci_free_statement($stid1);
oci_free_statement($stid2);
oci_free_statement($stid3);
oci_free_statement($stid4);
oci_close($connect);
		
    ?>
	</tr>
	
	</table>

    </body>
</html>