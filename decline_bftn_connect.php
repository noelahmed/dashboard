<?php
include('conn_connect.php');
?> 
<!DOCTYPE html >

<html >
<head>
<form method = "post" action = "download_decline_bftn_connect.php">
	<table align="center">
 <TR>
                   <td align="center">
                           <input name = "update" type = "submit" 
                              id = "update" value = "Download in Excel"></td>
                        </td>
						</TR>
						</TABLE>
						</FORM>
<title>DashBoard</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="layout.css" type="text/css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="jquery.jcarousel.setup.js"></script>
</head>
<body id="top">
<div class="wrapper col3">
  <div id="container">
    <div class="homepage">
      <ul>
       
          <div class="floater">
		  
            
          <?php
        //echo "Watch the page reload itself in 10 second!";
		$currentDateTime = date('Y-m-d');
	
	$query = mysqli_query($connect,"SELECT a.ref_no Sky_banking_ID,a.FAILED_REASON Decline_reason,a.T_TIME Transaction_date FROM eblconnect_lot_info_detail a
WHERE processed_status='Y' 
AND processed_success='N' 
AND txn_type='EBLBFT' 
AND DATE(processed_time )=$currentDateTime
");


?>
 
 
	<table border=1 width="70%">
	
		<tr>
			
			<td>Reference No</td>
			<td>Decline_reason</td>
			
			<td>Transaction_date</td></tr><?php
if($query)
		while($row=mysqli_fetch_array($query))
		{?>
   <tr>
			
			<td>
   <?php echo $row['Sky_banking_ID']; ?>
</td>

<td>
   <?php echo $row['Decline_reason']; ?>
</td>

<td>
   <?php echo $row['Transaction_date']; ?>
</td>
<?php
}
		
    ?>


		   </td>
		   
			</tr>
			</table>
        
          </div>
        </li>
		
	
           <br class="clear" />
    </div>
  </div>
</div>
    

</body>
</html>