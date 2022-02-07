<?php error_reporting(1);?>
<!doctype html>
<html lang="en">
  <head>
  <style>
.custom {
    width: 78px !important;
}

</style>
  <style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: .25px solid #ddd;
  padding: .25px;
}

#customers tr:nth-child(even){background-color: #ffc30b;}
#customers tr:nth-child(odd){background-color: #ffc30b;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #ffc30b;
  color: white;
}
</style>
 
<link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="popper.min.js"></script>
  <script src="bootstrap.min.js"></script></head>
   <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">-->
    <title>Digital Channels</title>
	<script src="jquery.min1.js"></script>
  <script src="bootstrap.min.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- carousel CSS -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <!--header icon CSS -->
    <link rel="icon" href="assets/img/fabicon.png">
    <!-- animations CSS -->
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <!-- font-awsome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- mobile menu CSS -->
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!--css animation-->
    <link rel="stylesheet" href="assets/css/animation.css">
    <!--css animation-->
    <link rel="stylesheet" href="assets/css/material-design-iconic-font.min.css">
    <!-- style CSS -->

    <!-- responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">
  </head>
  <body>
  <!--header area start-->
    <div class="header-area wow fadeInDown header-absolate" id="nav" data-0="position:fixed;" data-top-top="position:fixed;top:0;" data-edge-strategy="set">
        <div class="container">
            <div class="row">
                <div class="col-4 d-block d-lg-none">
                    <div class="mobile-menu"><button type="button" class="btn btn-warning"><B><font color="#006600" size="+2">Eastern Bank Limited</font>
						<BR><font color="#006600" size="-1">DiGiTAL CHANNELS DASHBOARD</font>
						</B></button></div>
                </div>
                
    <!--header area end-->

    <div class="welcome-area wow fadeInUp" id="home">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 align-self-center">
		
                    <div class="welcome-right">
					
                        <div class="welcome-text">
						

<?php
 $fp = fsockopen("172.25.28.6", 1433, $errno, $errstr);
 if (!$fp) {?>
 		 <marquee align="left" behavior="scroll"> <B><font color="#FF0000" style="font-family:Arial, Helvetica, sans-serif" size="+1">DIA MIDDLEWARE DOWN</marquee></font></B>

 <?php }?>
 <?php

   $haystack = shell_exec("start /b ping 192.168.3.159 -n 1");
$needle   = "Request timed out.";

if( strpos( $haystack, $needle ) == true) {?>
    <marquee align="left" behavior="scroll"> <B><font color="#FF0000" style="font-family:Arial, Helvetica, sans-serif" size="+1">DIA FB DOWN</marquee></font></B>

<?php
}
?>
 <?php

   $haystack = shell_exec("start /b ping 172.25.28.1 -n 1");
$needle   = "Request timed out.";

if( strpos( $haystack, $needle ) == true) {?>
    <marquee align="left" behavior="scroll"> <B><font color="#FF0000" style="font-family:Arial, Helvetica, sans-serif" size="+1">DIA FB DOWN</marquee></font></B>

<?php
}
?>
<?php

   $haystack = shell_exec("start /b ping 192.168.2.13 -n 1");
$needle   = "Request timed out.";

if( strpos( $haystack, $needle ) == true) {?>
    <marquee align="left" behavior="scroll"> <B><font color="#FF0000" style="font-family:Arial, Helvetica, sans-serif" size="+1">DIA VIBER DOWN</marquee></font></B>

<?php
}
?>

<?php    
$serverName = "192.168.46.192";   
$uid = "sa";     
$pwd = "Avaya@123";    
$databaseName = "avp_outbound";   
 
$connectionInfo = array( "UID"=>$uid,                              
                         "PWD"=>$pwd,                              
                         "Database"=>$databaseName);   
    
/* Connect using SQL Server Authentication. */    
$conn = sqlsrv_connect( $serverName, $connectionInfo);    
    

    
if( $conn === false )
{ echo "failed connection for FRAUD ALERT"; 
}

$sql = "SELECT  *
  FROM [avp_outbound].[dbo].[tbl_records]
  where classification_code='notdialed'
  and  datetime  >= DATEADD(HOUR, -2, GETDATE())";


$stmt = sqlsrv_query($conn,$sql);
if(sqlsrv_fetch($stmt) ===true)
{?>
     <marquee align="left" behavior="scroll"> <B><font color="#FF0000" style="font-family:Arial, Helvetica, sans-serif" size="+1">
	 <?php
    echo "Automatic dialing not working for fraud module"; ?>
	 </marquee></font></B>
<?php
}

  sqlsrv_close( $conn ); 
?> 

<table border="1" bordercolor="#FFFF00" id="customers">
<tr> <td>   <a href onClick="window.open('report_by_date_summary.php', 
                         'newwindow', 
                         'width=800,height=600')" title="click to open report">  <button type="button" class="btn btn-warning"><B><font color="#006600" size="-1">SUMMARY REPORT</font></B></button></a></td></tr>
<tr>
<td>                      
			
			
   <?php  
  include('total_txn_6_mon.php');
   
   ?></td></tr>
   </table>

	
                        </div>
						
						  
						 
                    </div>
                </div>
				
                <div class="col-12 col-md-6">
                    <div class="welcome-img">
                
						
			
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--welcome area end-->

    <!--about area start-->
    
    <!--about area end-->

    <!--single about area start-->
   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer area end-->

    <!-- jquery 2.2.4 js-->
 
  </body>
</html>