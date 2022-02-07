<?php
include('conn_sms.php');
?> 

<!DOCTYPE html >

<html >
<head>
<!--
<form method = "post" action = "download_decline_bill_IB.php">
	<table align="center">
 <TR>
                   <td align="center">
                           <input name = "update" type = "submit" 
                              id = "update" value = "Download in Excel"></td>
                        </td>
						</TR>
						</TABLE>
						</FORM>-->
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
		//$currentDateTime = date('Y-m-d');
	
$query = "SELECT  msg_id,ssl_status_desc,ssl_send_time
  FROM sms_message_daily_log  where trunc(sms_time)=(select trunc(max(sms_time)) from sms_message_daily_log) 
  and ssl_status_desc!='SUCCESS'";

$stid = oci_parse($connect, $query);
oci_execute($stid);

?>
 
 
	<table border=1 width="70%">
	
		<tr>
			
			<td>TXN_REF_NO</td>
			<td>Decline_reason</td>
			
			<td>Transaction_date</td></tr>
			<?php
while (oci_fetch($stid)) {?>
   <tr>
			
			<td>
			 <?php echo oci_result($stid, 'MSG_ID') . "<br>\n";?>

</td>

<td>
 <?php echo oci_result($stid, 'SSL_STATUS_DESC') . "<br>\n";?>
 
</td>

<td>
<?php echo oci_result($stid, 'SSL_SEND_TIME') . "<br>\n";?>

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