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
  
  $datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];
	
	$sql = "select distinct count(idfcatref) TXN1,DECODE(EXTRACT(month FROM a.datauthorization),1,'Jan',2,'Feb',
3,'Mar',4,'Apr',5,'May',6,'June',7,'July',8,'Aug',
9,'Sep',10,'Oct',11,'Nov',
'Dec') Months,sum(a.numamount) AMT,
EXTRACT(month FROM a.datauthorization) month_number,EXTRACT(year FROM a.datauthorization) years  
     from fcdbadminebl.admintxnunauthdata a where a.txnid in ('BPA','OAT','ITG','BDT')
and  to_char(a.datauthorization, 'yyyy-mm-dd') between '$datepicker' and '$datepicker1'
and codstatus='5'
GROUP BY EXTRACT(month FROM a.datauthorization),EXTRACT(year FROM a.datauthorization)
order by EXTRACT(year FROM a.datauthorization),EXTRACT(month FROM a.datauthorization) asc";
 


$stid = oci_parse($connect, $sql);


oci_execute($stid);

?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2><TD>INTERNET BANKING TRANSACTIONS</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> FROM DATE </td> <TD> <?php echo $datepicker ?></TD></tr>
		<tr align="right"> <td> TO DATE </td> <TD> <?php echo $datepicker1 ?></TD></tr>
		<tr>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Year</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Month</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. Of Succesful Transactions</td>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount Of Succesful Transactions</td>
			

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
   <?php echo oci_result($stid, 'TXN1') . "<br>\n";?>
</td>
<td>
   <?php echo oci_result($stid, 'AMT') . "<br>\n";?>
</td>


   <?php 
}?>


<?php
oci_free_statement($stid);
oci_close($connect);
		
    ?>
	</tr>
	
	</table>
<form method = "post" action="report_status_download_IB.php"  >
						
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