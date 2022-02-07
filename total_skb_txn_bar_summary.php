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
		
	$query = mysqli_query($connect,"SELECT DISTINCT
CASE 
  WHEN actionName = 'billsPay' THEN 'BILLS PAY'
  WHEN actionName = 'ownAccountTransfer' THEN 'OWN ACCOUNT TRANSFER'
  WHEN actionName = 'eblAccountTransfer' THEN 'EBL ACCOUNT TRANSFER'
  WHEN actionName = 'otherBankTransfer' THEN 'OTHER BANK TRANSFER'
  WHEN actionName = 'Bkash' THEN 'BKASH TRANSFER'
  ELSE 'UTILITY BILL'
END AS actionName,COUNT(*) total FROM app_user_activity_log
 WHERE LEFT({fn MONTHNAME(commDtTm)}, 3)='$value'
 AND YEAR(commDtTm )=$currentDateTime
 AND actionName IN ('billsPay',
'ownAccountTransfer',
'eblAccountTransfer',
'otherBankTransfer',
'Bkash',
'Utility_bill')
GROUP BY actionName 
");
 
 

		?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif">FINANCIAL TRANSACTIONS</tr><tr></h2>

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
