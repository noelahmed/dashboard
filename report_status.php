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
	
	 $connect = mysqli_connect("192.168.5.80", "queryuser", "queryuser1", "skybanklive") or die("error connecting to database");
if (!$connect) {
    die("The SKY BANKING Server is Unexpectedly Closed: " . mysqli_connect_error());
}
        //echo "Watch the page reload itself in 10 second!";
		$datepicker = $_REQUEST['datepicker'];
	$datepicker1 = $_REQUEST['datepicker1'];

	 $query = mysqli_query($connect,"SELECT  T.tt 'YEAR',T.MONTH 'MONTH',T.ll 'MONTH_NUMBER',
SUM(T.total) 'Transactions_Number',  SUM(T.am) 'Transactions_amount' FROM (
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,
MONTH(creationDtTm) ll,SUM(amount) am,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH
 FROM apps_bill_pay a WHERE a.isSuccess='Y' AND DATE(a.creationDtTm ) BETWEEN '$datepicker' AND '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
UNION ALL
SELECT COUNT(a.trnReference) total,YEAR(a.creationDtTm ) tt,MONTH(creationDtTm) ll,SUM(amount) am,
IFNULL(ELT(FIELD(MONTH(creationDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH
 FROM apps_transaction a WHERE a.isSuccess='Y' AND a.trnType IN ('06','07','08') AND DATE(a.creationDtTm ) BETWEEN '$datepicker' AND '$datepicker1'
 GROUP BY MONTH(creationDtTm),YEAR(a.creationDtTm ) 
) T
GROUP BY T.tt,T.MONTH
ORDER BY T.tt,T.ll ASC");
 
?>
		
	<table border=1 width="30%" id="customers">
	
		<tr><td><h2 align="center">SKYBANKING TRANSACTIONS</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> FROM DATE </td> <TD> <?php echo $datepicker ?></TD></tr>
		<tr align="right"> <td> TO DATE </td> <TD> <?php echo $datepicker1 ?></TD></tr>
		<tr>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Year</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Month</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. Of Succesful Transactions</td>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount Of Succesful Transactions</td>
			</font>
		
		
			</tr>
			<?php
			while($row=mysqli_fetch_array($query))
		{?>
   
			<tr>
			
			<td>
   <?php  echo $row['YEAR']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   
   ?>
</td>

<td>
   <?php echo $row['MONTH']; 
   
   
   ?>
</td>


		<td>

						
						 <?php echo $row['Transactions_Number']; ?>
</td>
<td>

						
						 <?php echo $row['Transactions_amount']; ?>
</td>
</tr>

<?php
}
		
    ?>
	
	
	</table>
<form method = "post" action="report_status_download.php"  >
						
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
