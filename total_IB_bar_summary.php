
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
	
	$sql = "select b.description tt,count(*) TXN
     from auditlog a,msttxn b where a.idtxn = b.idtxn
and to_char(trunc(a.dattxn),'MON')=UPPER('$value')
and EXTRACT(year FROM a.dattxn)=$currentDateTime
AND a.idtxn not in ('BPA','OAT','ITG','BDT')
GROUP BY b.description";
 



$stid = oci_parse($connect, $sql);



oci_execute($stid);?>


   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif"> NON FINANCIAL TRANSACTIONS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Transactions</td></font>
		
	
			

			</tr>
			
			<?php
			while (oci_fetch($stid)) {?>
			<tr>
			
			<td><?php echo oci_result($stid, 'TT') . "<br>\n";?></td>
			<td>
   <?php  oci_result($stid, 'TXN') . "<br>\n";
   echo $_SESSION['IB_BILLPAYMENT']=oci_result($stid, 'TXN');
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