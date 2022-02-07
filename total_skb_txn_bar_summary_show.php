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
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {background-color: #008CBA;
border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
} /* Blue */
.button3 {background-color: #f44336;} /* Red */ 
.button4 {background-color: #e7e7e7; color: black;} /* Gray */ 
.button5 {background-color: #555555;} /* Black */
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

	 $query = mysqli_query($connect,"SELECT COUNT(*) total,
	IFNULL(ELT(FIELD(MONTH(commDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH,YEAR(commDtTm ) tt
	FROM app_user_activity_log
 WHERE LEFT({fn MONTHNAME(commDtTm)}, 3)='$value'
 AND YEAR(commDtTm )=$currentDateTime
 AND actionName IN ('billsPay',
'ownAccountTransfer',
'eblAccountTransfer',
'otherBankTransfer',
'Bkash',
'Utility_bill')
GROUP BY MONTH(commDtTm),YEAR(commDtTm )");

$query1 = mysqli_query($connect,"SELECT COUNT(*) total,
	IFNULL(ELT(FIELD(MONTH(commDtTm),
       1, 2, 3, 4,5, 6, 7,8,9,10,11,12),'Jan','Feb','Mar','Apr',
       'May','June','July',
       'Aug','Sep','Oct','Nov'),'Dec')  AS MONTH,YEAR(commDtTm ) tt
	FROM app_user_activity_log
 WHERE LEFT({fn MONTHNAME(commDtTm)}, 3)='$value'
 AND YEAR(commDtTm )=$currentDateTime
 AND actionName IN ('transactionHistory',
'billerRegister',
'accountDetail',
'cardsSummary',
'priorityRequest',
'currentLoanDetail',
'bankingRequest',
'deleteBiller',
'get_credit_card_list',
'get_balance',
'get_statement_list')
GROUP BY MONTH(commDtTm),YEAR(commDtTm )");
 
?>
		
	<table border=1 width="30%" id="customers">
	
		<tr><td><h2 align="center">SKYBANKING TRANSACTIONS</h2></td><td><img src="ebl_logo.jpg" width="131" height="116" /></td></tr>
		<tr align="right"> <td> Month </td> <TD> <?php echo $value ?></TD></tr>
		<tr align="right"> <td> Year </td> <TD> <?php echo $currentDateTime ?></TD></tr>
		<tr align="right">
			<td >Total No. of Financial Transactions</td>
			<?php
			while($row=mysqli_fetch_array($query))
		{?>
   
			<td>
   <?php  echo $row['total']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];total_skb_txn_bar_summary
   }
   ?>
   </td><td>
   <form method = "post" action="total_skb_txn_bar_summary.php" >
						
	
						<INPUT id=NAME size=22 name=value value="<?php echo $value ?>" type="hidden">
		<INPUT id=NAME size=22 name=currentDateTime value="<?php echo $currentDateTime ?>" type="hidden">
                           <input name = "update" type = "submit" 
                              id = "update" value = " Show Details" class="button2"  >
						
						
		
		
                     
				</FORM>	</td></tr>
				<TR align="right">
			
			<td>Total No. of Non Financial Transactions</td>
			
		
		
			
			
</td>

<?php
			while($row1=mysqli_fetch_array($query1))
		{?>
   
			<td>
   <?php  echo $row1['total']; 
   //echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   }
   ?>
   </td><td>
   <form method = "post" action="total_skb_txn_bar.php">
						
	
						<INPUT id=NAME size=22 name=value value="<?php echo $value ?>" type="hidden">
		<INPUT id=NAME size=22 name=currentDateTime value="<?php echo $currentDateTime ?>" type="hidden">
                           <input name = "update" type = "submit" 
                              id = "update" value = " Show Details"  class="button2">
						
		
		
                     
				</FORM>	
</td>
</tr>





	
	
	</table>

    </body>
</html>
