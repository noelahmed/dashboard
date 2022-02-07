 <?php
include('conn_dia.php');
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
		$value = $_REQUEST['value'];
		$currentDateTime = date('Y');
		
	
	$sql = "select count(*) TXN,TO_CHAR( sum(amount)/100000, '999,999,999,999.99') AMT,to_char(max(trn_dt),'DD-MON-RRRR HH24:MI:SS AM') tt
 from mobile_recharge_entry where ft_card_status  in ('000','Y')
and topup_status='S'
and  to_char(trunc(trn_dt),'MON')=UPPER('$value')
and EXTRACT(year FROM trn_dt)=$currentDateTime
";
 

//decline
$sql4 = "SELECT SUM(T.TXN) TXN4 FROM
(

select count(*) TXN 
 from mobile_recharge_entry where ft_card_status not in ('000','Y')
 and  trunc(trn_dt)=(select trunc(max(trn_dt)) from mobile_recharge_entry) 
UNION ALL
 select count(*) TXN 
 from mobile_recharge_entry where ft_card_status  in ('000','Y')
and topup_status!='S'
and  to_char(trunc(trn_dt),'MON')=UPPER('$value')
and EXTRACT(year FROM trn_dt)=$currentDateTime

)T";




$stid = oci_parse($connect, $sql);
$stid4 = oci_parse($connect, $sql4);



oci_execute($stid);
oci_execute($stid4);


while (oci_fetch($stid)) {?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">Mobile TopUp</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Transactions</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount (BDT in lac)</td></font>
			
			
			
			</tr><tr>
			<td>Mobile TopUp</td>
			<td>
   <?php echo oci_result($stid, 'TXN') . "<br>\n";
     $_SESSION['DIATOPUP']=oci_result($stid, 'TXN');
   
   ?>
</td>

<td>
   <?php echo oci_result($stid, 'AMT') . "<br>\n";
   
   }
   ?>
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