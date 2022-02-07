 <?php
include('conn_remit.php');
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
	
	$query = mysqli_query($connect,"SELECT COUNT(tt_reference_no) TXN,SUM(amount) AMT,MAX(upload_time ) Last_succesful_transaction FROM remitupload_lot_no_info_detail WHERE  download_status='Y'
AND DATE(upload_time )=(SELECT MAX(DATE(upload_time ))  FROM 
remitupload_lot_no_info_detail WHERE  download_status='Y')");
 $query1 = mysqli_query($connect,"SELECT COUNT(tt_reference_no) TXN,SUM(amount) AMT,MAX(upload_time ) Last_succesful_transaction FROM remitupload_lot_no_info_detail WHERE  download_status='N'
AND DATE(upload_time )=(SELECT MAX(DATE(upload_time ))  FROM 
remitupload_lot_no_info_detail WHERE  download_status='N')");
 
 
 //echo "$currentDateTime";
  //echo "DATE(upload_time )";

		while($row=mysqli_fetch_array($query))
		{?>



 
	<table border=1 width="30%" id="customers">
	
		<tr><h2>EBL REMITTANCE</tr><tr></h2>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Transaction Type</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of processed TXN</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Amount of processed TXN</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">Last Uploaded Time</td></font>
			<td bgcolor="#99CCCC"><font color="#FFFFFF" size="-1">No. of waited TXN</td></font>
			
		
			</tr><tr>
			<td>Flex Remit</td>
			<td>
   <?php echo $row['TXN']; 
   
   $_SESSION['CON_RMTTRF']=$row['TXN'];
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
   
						 <font color="#FF9933"><B>
						 <?php echo $row1['TXN']; ?></a>
</td>
</tr>

<?php
}
		
    ?>
	</tr>
	
	</table>

    </body>
</html>