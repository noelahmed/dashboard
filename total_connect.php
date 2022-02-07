 <?php
include('conn_connect.php');
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
		$currentDateTime = date('Y-m-d');
	
	$query = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLACT' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLACT'
)");
 $query1 = mysqli_query($connect,"select count(ref_no) TXN from eblconnect_lot_info_detail where processed_status='Y' 
and processed_success='N' and txn_type='EBLACT' and DATE(processed_time )=$currentDateTime");
 
 //OWN Account transfer
 $query2 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLBFT' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLBFT'
)");
 $query3 = mysqli_query($connect,"select count(ref_no) TXN from eblconnect_lot_info_detail where processed_status='Y' and processed_success='N'
and txn_type='EBLBFT' and DATE(processed_time )=$currentDateTime");
 
 //ebl card transfer
 $query4 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLRTG' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLRTG'
)");
 $query5 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_status='Y' and processed_success='N'
and txn_type='EBLRTG' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_status='Y' 
and processed_success='N'
and txn_type='EBLRTG'
)");

//ebl card transfer
 $query6 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLCDP' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLCDP'
)");
 $query7 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_status='Y' and processed_success='N'
and txn_type='EBLCDP' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_status='Y' 
and processed_success='N'
and txn_type='EBLCDP'
)");
 
 
 //other Account transfer
 $query8 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction  from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLOTP' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLOTP'
)");
 $query9 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction from eblconnect_lot_info_detail where processed_status='Y' and processed_success='N'
and txn_type='EBLOTP' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_status='Y' 
and processed_success='N'
and txn_type='EBLOTP'
)");
 //echo $currentDateTime;
 $query10 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction from eblconnect_lot_info_detail where processed_success='Y'
and txn_type='EBLPUL' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_success='Y'
and txn_type='EBLPUL'
)");
 $query11 = mysqli_query($connect,"select count(ref_no) TXN,FORMAT(sum(amount)/100000, 2) AMT,max(processed_time ) Last_succesful_transaction from eblconnect_lot_info_detail where processed_status='Y' and processed_success='N'
and txn_type='EBLPUL' and DATE(processed_time )=(select DATE(max(processed_time )) from eblconnect_lot_info_detail
where processed_status='Y' 
and processed_success='N'
and txn_type='EBLPUL'
)");
 
 

		while($row=mysqli_fetch_array($query))
		{?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2>EBL CONNECT TRANSACTIONS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Approved TXN</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount (BDT in lac)</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last successful Transaction</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Decline TXN</td></font>
			
			
			</tr><tr>
			<td>Account Transfer</td>
			<td>
   <?php echo $row['TXN']; 
   
   $_SESSION['CON_OTACTRF']=$row['TXN'];
   ?>
</td>

<td>
   <?php echo $row['AMT']; ?>
</td>
<td>
   <?php echo $row['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row1=mysqli_fetch_array($query1))
		{?>
		<td>
   <a href onClick="window.open('decline_bill_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
						 <?php echo $row1['TXN']; ?></a>
</td>
</tr>

<?php
}
		
    ?>
	<!--OWN ACC TRF-->
<?php

		while($row2=mysqli_fetch_array($query2))
		{?>
<tr>
			<td>BFTN Transfer</td>
			<td>
			
   <?php echo $row2['TXN']; 
   $_SESSION['CON_BFTTRF']=$row2['TXN'];
   ?>
</td>

<td>
   <?php echo $row2['AMT']; ?>
</td>
<td>
   <?php echo $row2['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row3=mysqli_fetch_array($query3))
		{?>
		<td>
		<a href onClick="window.open('decline_bftn_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row3['TXN']; ?></B></font></a>
</td>
</tr>
<?php
}
		
    ?>
<!--OWN ACC TRF-->


<!--EBL ACC TRF-->
<?php

		while($row4=mysqli_fetch_array($query4))
		{?>
<tr>
			<td>RTGS Transfer</td>
			<td>
   <?php echo $row4['TXN']; 
   
   $_SESSION['CON_CRDTRF']=$row4['TXN'];
   ?>
</td>

<td>
   <?php echo $row4['AMT']; ?>
</td>
<td>
   <?php echo $row4['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row5=mysqli_fetch_array($query5))
		{?>
		<td>
		<a href onClick="window.open('decline_rtgs_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row5['TXN']; ?></B></font></a>
</td>

</tr>

<?php
}
		
    ?>
	<!--EBL ACC TRF-->
	
<!--Other ACC TRF-->
<?php

		while($row6=mysqli_fetch_array($query6))
		{?>
<tr>
			<td>Card Payment</td>
			<td>
   <?php echo $row6['TXN']; 
   
   $_SESSION['CON_CRDTTRF']=$row6['TXN'];
   ?>
</td>

<td>
   <?php echo $row6['AMT']; ?>
</td>
<td>
   <?php echo $row6['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row7=mysqli_fetch_array($query7))
		{?>
		<td>
		<a href onClick="window.open('decline_card_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row7['TXN']; ?></B></font></a>
</td>
</tr>

<?php
}
		
    ?>
	<!--EBL ACC TRF-->
	
<!--OTP-->
<?php

		while($row8=mysqli_fetch_array($query8))
		{?>
<tr>
			<td> GL PAYMENT</td>
			<td>
   <?php echo $row8['TXN']; 
   
    $_SESSION['CON_GLTTRF']=$row8['TXN'];
   ?>
</td>

<td>
   <?php echo $row8['AMT']; ?>
</td>
<td>
   <?php echo $row8['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row9=mysqli_fetch_array($query9))
		{?>
		<td>
		<a href onClick="window.open('decline_gl_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row9['TXN']; ?></B></font></a>
</td>
</tr>

<?php
}
		
    ?>	
<!--EBL ACC TRF-->
	
<!--OTP-->
<?php

		while($row10=mysqli_fetch_array($query10))
		{?>
<tr>
			<td>Other Bank Pull</td>
			<td>
   <?php echo $row10['TXN'];
    $_SESSION['CON_OTBTRF']=$row10['TXN'];
   
    ?>
</td>

<td>
   <?php echo $row10['AMT']; ?>
</td>
<td>
   <?php echo $row10['Last_succesful_transaction']; ?>
</td>
<?php
}
		
    ?>

<?php

		while($row11=mysqli_fetch_array($query11))
		{?>
		<td>
		<a href onClick="window.open('decline_pull_connect.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row11['TXN']; ?></B></font></a>
</td>
</tr>

<?php
}
		
    ?>	
	</table>

    </body>
</html>