<?php
//include('timer.php');
?> 
<!doctype html>
<html lang="en">
  <head>
   <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">-->
    <title>Digital Banking</title>
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
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">
  </head>
  <body>
   

    <!--welcome area start-->
    <div class="welcome-area wow fadeInUp" id="home">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                 <div class="col-12 col-md-6">
                    <div class="welcome-right">
                        <div class="welcome-text">
						<table width="40%" id="customers" align="left">
						<tr>
						<td>
						<a href="#" class="logibtn gradient-btn"><B><?php include"total_txn_6_mon.php"?></a></B></TD>
						<TD>
						<a href="#" class="logibtn gradient-btn"><B> <?php include"total_txn_ib_mon.php"?></a></B></TD>
						<TD>
						<a href="#" class="logibtn gradient-btn"><B> <?php include"total_txn_connect_mon.php"?></a></B></TD>
						<TD>
						<a href="#" class="logibtn gradient-btn"><B> <?php include"total_txn_dia_mon.php"?></a></B></TD>
						<TD>
						<a href="#" class="logibtn gradient-btn"><B> <?php include"total_txn_ib_mon.php"?></a></B></TD>
						<TD>
						<a href="#" class="logibtn gradient-btn"><B> <?php include"total_txn_sms_mon.php"?></a></B></TD>
						
						</tr>
                              
			
			<tr>
			
		   
		    
			</tr></table>
			
                        </div>
						<div class="welcome-text">
                              <table width="30%" id="customers" align="left">
			
			<tr>
			<td>
            <font size="+1" color="#00FF66"> <B>SKY BANKING TRANSACTIONS</B></font>
            <?php include"total_skb_txn.php"?>
		   </td>
		  <td>
            <font size="+1" color="#00FF66"> <B>INTERNET BANKING TRANSACTIONS</B></font>
            <?php include"total_IB.php"?>
		   </td>
		  <TD>
		  <font size="+1" color="#00FF66"> <B>TRANSACTIONS CONNECT</B></font>
            <?php include"total_connect.php"?></TD>
		   
		    
			</tr></table>
			
                        </div>
						<div class="welcome-text">
      <table width="30%" id="customers" align="left">
			
			<tr>
			
		   <td>
             <font size="+1" color="#00FF66"> <B>EBL DIA TOPUP</B></font>
			 <?php include"total_otp.php"?>
            
		   </td>
		   <td>
            <font size="+1" color="#00FF66"> <B>EBL DIA OTP</B></font>
        <?php include"total_dia.php"?>
		   </td>
		   <td>
            <font size="+1" color="#00FF66"> <B>EBL SMS</B></font>
            <?php include"total_SMS.php"?>
		   </td>
		    
			</tr></table>
			
                        </div>
						
                   <div class="welcome-text">
                              <table width="30%" id="customers" align="left">
			
			<tr>
			
		   
		   
		    
			</tr></table>
			
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
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <!-- popper js-->
    <script src="assets/js/popper.js"></script>
    <!-- carousel js-->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- wow js-->
    <script src="assets/js/wow.min.js"></script>
    <!-- bootstrap js-->
    <script src="assets/js/bootstrap.min.js"></script>\
    <!--skroller js-->
    <script src="assets/js/skrollr.min.js"></script>
    <!--mobile menu js-->
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <!--particle s-->
    <script src="assets/js/particles.min.js"></script>
    <!-- main js-->
    <script src="assets/js/main.js"></script>
  </body>
</html>