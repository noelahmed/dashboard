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
		$value = $_REQUEST['value'];
		$currentDateTime = date('Y');
		
	$query = mysqli_query($connect,"select distinct 
	
	CASE 
  WHEN actionName = 'transactionHistory' THEN 'TRANSACTION HISTORY'
  WHEN actionName = 'billerRegister' THEN 'BILLER REGISTER'
  WHEN actionName = 'accountDetail' THEN 'ACCOUNT DETAIL'
  WHEN actionName = 'cardsSummary' THEN 'CARDS SUMMARY'
  WHEN actionName = 'priorityRequest' THEN 'PRIORITY SERVICE REQUEST'
  WHEN actionName = 'currentLoanDetail' THEN 'LOAN DETAIL'
  WHEN actionName = 'bankingRequest' THEN 'SERVICE REQUEST'
  WHEN actionName = 'deleteBiller' THEN 'DELETE BILLER'
  WHEN actionName = 'get_credit_card_list' THEN 'CREDIT CARD LIST CHECK'
  WHEN actionName = 'get_balance' THEN 'CHECK BALANCE'
  ELSE 'STATEMENT CHECK'
END AS	actionName,COUNT(*) total from app_user_activity_log
 where LEFT({fn MONTHNAME(commDtTm)}, 3)='$value'
 and YEAR(commDtTm )=$currentDateTime
 AND actionName IN 
 ('transactionHistory',
'billerRegister',
'accountDetail',
'cardsSummary',
'priorityRequest',
'currentLoanDetail',
'bankingRequest',
'deleteBiller',
'get_credit_card_list',
'get_balance',
'get_statement_list'
)
GROUP BY actionName 
");
 
 

		?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">NON FINANCIAL TRANSACTIONS</tr><tr></h2>

			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Usage type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Usage</td></font>

			
		
			</tr>
	<?php		
while($row=mysqli_fetch_array($query))
		{?>		
			<tr>
			
			<td>
   <?php  echo $row['actionName']; 

   
   ?>
</td>

<td>
   <?php echo $row['total']; 
   
   }
   ?>
</td>

	
	</table>
 	
    </body>
</html>