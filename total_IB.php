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
        //echo "Watch the page reload itself in 10 second!";
		//$currentDateTime = date('d-m-Y');
	
	$sql = "select count(*) TXN,TO_CHAR( sum(a.numamount)/100000, '999,999,999,999.99') AMT,max(a.datauthorization) Last_succesful_transaction
	 from fcdbadminebl.admintxnunauthdata a where a.txnid='BPA'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='5'";
 $sql1 = "select count(*) TXN1,TO_CHAR( sum(a.numamount)/100000, '999,999,999,999.99') AMT1,max(a.datauthorization) Last_succesful_transaction 
 from fcdbadminebl.admintxnunauthdata a where a.txnid='OAT'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='5'";
 $sql2= "select count(*) TXN2,TO_CHAR( sum(a.numamount)/100000, '999,999,999,999.99') AMT2,max(a.datauthorization) Last_succesful_transaction 
 from fcdbadminebl.admintxnunauthdata a where a.txnid='ITG'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='5'";
 $sql3= "select count(*) TXN3,TO_CHAR( sum(a.numamount)/100000, '999,999,999,999.99') AMT3,max(a.datauthorization) Last_succesful_transaction
  from fcdbadminebl.admintxnunauthdata a where a.txnid='BDT'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='5'";

//decline
$sql4 = "select NVL(count(*),0) TXN4 from fcdbadminebl.admintxnunauthdata a where a.txnid='BPA'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='4'";
$sql5 = "select NVL(count(*),0) TXN5 from fcdbadminebl.admintxnunauthdata a where a.txnid='OAT'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='4'";
 $sql6= "select NVL(count(*),0) TXN6  from fcdbadminebl.admintxnunauthdata a where a.txnid='ITG'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='4'";
 $sql7= "select NVL(count(*),0) TXN7 from fcdbadminebl.admintxnunauthdata a where a.txnid='BDT'
and trunc(a.datauthorization)=(select trunc(max(a.datauthorization)) from fcdbadminebl.admintxnunauthdata a) 
and codstatus='4'";



$stid = oci_parse($connect, $sql);
$stid1 = oci_parse($connect, $sql1);
$stid2 = oci_parse($connect, $sql2);
$stid3 = oci_parse($connect, $sql3);
$stid4 = oci_parse($connect, $sql4);
$stid5 = oci_parse($connect, $sql5);
$stid6 = oci_parse($connect, $sql6);
$stid7 = oci_parse($connect, $sql7);


oci_execute($stid);
oci_execute($stid1);
oci_execute($stid2);
oci_execute($stid3);
oci_execute($stid4);
oci_execute($stid5);
oci_execute($stid6);
oci_execute($stid7);

while (oci_fetch($stid)) {?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2>INTERNET BANKING TRANSACTIONS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Approved TXN</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount (BDT in lac)</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last successful Transaction</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Decline TXN</td></font>
			

			</tr><tr>
			<td>Bill payment</td>
			<td>
   <?php  oci_result($stid, 'TXN') . "<br>\n";
   echo $_SESSION['IB_BILLPAYMENT']=oci_result($stid, 'TXN');
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'AMT') . "<br>\n";?>
</td>

<td>
   <?php echo oci_result($stid, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid4)) {?>
   
	
	
	
			<td>
			  <a href onClick="window.open('decline_bill_IB.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid4, 'TXN4') . "<br>\n";

}?></a>
</td>

</tr>
<tr>
			<td>Own Account Transfer</td>

<?php
while (oci_fetch($stid1)) {?>
   
		 	
			<td>
   <?php echo oci_result($stid1, 'TXN1') . "<br>\n";
   
    $_SESSION['IB_ACTRF']=oci_result($stid1, 'TXN1');
?>
</td>

<td>
   <?php echo oci_result($stid1, 'AMT1') . "<br>\n";?>
<td>
   <?php echo oci_result($stid1, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid5)) {?>
   
	
	
	
			<td>
			 <a href onClick="window.open('decline_oat_IB.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid5, 'TXN5') . "<br>\n";

}?>
</td></B></a>

</tr>
<tr>
			<td>EBL Account Transfer</td>

<?php
while (oci_fetch($stid2)) {?>
   
		 	
			<td>
   <?php echo oci_result($stid2, 'TXN2') . "<br>\n";
   $_SESSION['IB_EBACTRF']=oci_result($stid2, 'TXN2');
?>
</td>

<td>
   <?php echo oci_result($stid2, 'AMT2') . "<br>\n";?>
<td>
   <?php echo oci_result($stid2, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid6)) {?>
   
	
	
	
			<td>
			 <a href onClick="window.open('decline_EBL_IB.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid6, 'TXN6') . "<br>\n";

}?>
</B></a>

</tr>
<tr>
			<td>Other Bank Transfer</td>

<?php
while (oci_fetch($stid3)) {?>
   
		 	
			<td>
   <?php echo oci_result($stid3, 'TXN3') . "<br>\n";
    $_SESSION['IB_OTACTRF']=oci_result($stid3, 'TXN3');
?>
</td>

<td>
   <?php echo oci_result($stid3, 'AMT3') . "<br>\n";?>
<td>
   <?php echo oci_result($stid3, 'LAST_SUCCESFUL_TRANSACTION') . "<br>\n";
}?>
</td>
<?php
while (oci_fetch($stid7)) {?>
   
	
	
	
			<td>
			 <a href onClick="window.open('decline_OTB_IB.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo oci_result($stid7, 'TXN7') . "<br>\n";

}?>
</B></a>

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