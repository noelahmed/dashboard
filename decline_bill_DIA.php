<?php
include('conn_dia.php');
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
	
$query = "SELECT T.trn_ref_no,T.ft_card_des,T.trn_dt FROM
(

select trn_ref_no,ft_card_des,trn_dt
 from mobile_recharge_entry where ft_card_status not in ('000','Y')
 and  trunc(trn_dt)=(select trunc(max(trn_dt)) from mobile_recharge_entry) 
UNION ALL
 select trn_ref_no,ft_card_des,trn_dt
 from mobile_recharge_entry where ft_card_status  in ('000','Y')
and topup_status!='S'
and  trunc(trn_dt)=(select trunc(max(trn_dt)) from mobile_recharge_entry) 

)T";

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
			 <?php echo oci_result($stid, 'TRN_REF_NO') . "<br>\n";?>

</td>

<td>
 <?php echo oci_result($stid, 'FT_CARD_DES') . "<br>\n";?>
 
</td>

<td>
<?php echo oci_result($stid, 'TRN_DT') . "<br>\n";?>

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