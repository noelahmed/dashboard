 <?php
include('conn_skb.php');
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
	
	$query = mysqli_query($connect,"select count(a.trnReference) TXN,FORMAT(sum(a.amount)/100000, 2) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_bill_pay a where a.isSuccess='Y' and DATE(a.creationDtTm )='$currentDateTime'");
 $query1 = mysqli_query($connect,"select count(*) TXN
 from apps_bill_pay a where a.isSuccess='N' and DATE(a.creationDtTm )='$currentDateTime'");
 
 //OWN Account transfer
 $query2 = mysqli_query($connect,"select count(a.trnReference) TXN,FORMAT(sum(a.amount)/100000, 2) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_transaction a where a.isSuccess='Y' and a.trnType='06' and DATE(a.creationDtTm )='$currentDateTime'");
 $query3 = mysqli_query($connect,"select count(*) TXN
 from apps_transaction a where a.isSuccess='N' and a.trnType='06' and DATE(a.creationDtTm )='$currentDateTime'");
 
 //ebl Account transfer
 $query4 = mysqli_query($connect,"select count(a.trnReference) TXN,FORMAT(sum(a.amount)/100000, 2) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_transaction a where a.isSuccess='Y' and a.trnType='07' and DATE(a.creationDtTm )='$currentDateTime'");
 $query5 = mysqli_query($connect,"select count(*) TXN
 from apps_transaction a where a.isSuccess='N' and a.trnType='07' and DATE(a.creationDtTm )='$currentDateTime'");
 
 
 //other Account transfer
 $query6 = mysqli_query($connect,"select count(a.trnReference) TXN,FORMAT(sum(a.amount)/100000, 2) AMT,max(a.creationDtTm ) Last_succesful_transaction
 from apps_transaction a where a.isSuccess='Y' and a.trnType='08' and DATE(a.creationDtTm )='$currentDateTime'");
 $query7 = mysqli_query($connect,"select count(*) TXN
 from apps_transaction a where a.isSuccess='N' and a.trnType='08' and DATE(a.creationDtTm )='$currentDateTime'");
 //echo $currentDateTime;
 

		while($row=mysqli_fetch_array($query))
		{?>
   
	<table border=1 width="30%" id="customers">
	
		<tr><h2>SKYBANKING TRANSACTIONS</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Approved TXN</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount (BDT in lac)</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last successful Transaction</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of Decline TXN</td></font>
			
		
			</tr><tr>
			<td>Bill payment</td>
			<td>
   <?php  $row['TXN']; 
   echo $_SESSION['SK_BILLPAYMENT']=$row['TXN'];
   //echo $_SESSION['SK_BILLPAYMENT'];
   
   ?>
</td>

<td>
   <?php echo $row['AMT']; 
   
   
   ?>
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
   <a href  onClick="window.open('decline_bill.php', 
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
			<td>Own Account Transfer</td>
			<td>
			
   <?php echo $row2['TXN']; 
   $_SESSION['SK_ACTRF']=$row2['TXN'];
   ?>
</td>

<td>
   <?php echo $row2['AMT']; 
   
    
   ?>
   
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
		<a href  onClick="window.open('decline_own_acc_trf_detail.php', 
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
			<td>EBL Account Transfer</td>
			<td>
   <?php echo $row4['TXN']; 
   $_SESSION['SK_EBACTRF']=$row4['TXN'];
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
		<a href  onClick="window.open('decline_ebl_acc_trf_detail.php', 
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
			<td>Other Bank Transfer</td>
			<td>
   <?php echo $row6['TXN']; 
   
   $_SESSION['SK_OTACTRF']=$row6['TXN'];
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
		<a href  onClick="window.open('decline_other_acc_trf_detail.php', 
                         'newwindow', 
                         'width=800,height=600')">
						 <font color="#FF0033"><B>
   <?php echo $row7['TXN']; ?></B></font></a>
</td>
</tr>

<?php
}
		
    ?>
	
	</table>
 	
    </body>
</html>