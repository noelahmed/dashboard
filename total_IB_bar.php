
 <?php
include('conn_ib.php');
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
	
	$sql = "select count(*) TXN,sum(a.numamount) AMT,max(a.datauthorization) Last_succesful_transaction
	 from fcdbadminebl.admintxnunauthdata a where a.txnid='BPA'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='5'";
 $sql1 = "select count(*) TXN1,sum(a.numamount) AMT1,max(a.datauthorization) Last_succesful_transaction 
 from fcdbadminebl.admintxnunauthdata a where a.txnid='OAT'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='5'";
 $sql2= "select count(*) TXN2,sum(a.numamount) AMT2,max(a.datauthorization) Last_succesful_transaction 
 from fcdbadminebl.admintxnunauthdata a where a.txnid='ITG'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='5'";
 $sql3= "select count(*) TXN3,sum(a.numamount) AMT3,max(a.datauthorization) Last_succesful_transaction
  from fcdbadminebl.admintxnunauthdata a where a.txnid='BDT'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='5'";

//decline
$sql4 = "select NVL(count(*),0) TXN4 from fcdbadminebl.admintxnunauthdata a where a.txnid='BPA'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='4'";
$sql5 = "select NVL(count(*),0) TXN5 from fcdbadminebl.admintxnunauthdata a where a.txnid='OAT'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='4'";
 $sql6= "select NVL(count(*),0) TXN6  from fcdbadminebl.admintxnunauthdata a where a.txnid='ITG'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
and codstatus='4'";
 $sql7= "select NVL(count(*),0) TXN7 from fcdbadminebl.admintxnunauthdata a where a.txnid='BDT'
and to_char(trunc(a.datauthorization),'MON')=UPPER('$value')
and EXTRACT(year FROM a.datauthorization)=$currentDateTime
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
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">FINANCIAL TRANSACTIONS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Transactions</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount of Transactions</td></font>
	
			

			</tr><tr>
			<td>Bill payment</td>
			<td>
   <?php  oci_result($stid, 'TXN') . "<br>\n";
   echo $_SESSION['IB_BILLPAYMENT']=oci_result($stid, 'TXN');
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'AMT') . "<br>\n";
   }
   ?>
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
   <?php echo oci_result($stid1, 'AMT1') . "<br>\n";
   }
   ?>
</td>

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
   <?php echo oci_result($stid2, 'AMT2') . "<br>\n";
   
   }
   ?>
</td>

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
   <?php echo oci_result($stid3, 'AMT3') . "<br>\n";
   
   }
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
<?php include "total_IB_bar_summary.php";?>