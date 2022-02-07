<?php
if(isset($_POST['status'])){
    $status = $_POST['status'];
    switch ($status) {
        case 'SKYBANKING':
            
?>
<?php
   
include('report_status.php');

    
?>
<?php
          
		    break;
       case 'INTERNETBANKING':?>
	   
   

	<?php
   
include('report_status_ib.php');

    
?>
<?php
          
		    break;
       case 'EBLCONNECT':?>
	   
   

	<?php
   
include('report_status_connect.php');

    
?>
<?php
          
		    break;
       case 'EBLDIA':?>
	   
   

	<?php
   
include('report_status_DIA.php');

    
?>
<?php
          
		    break;
       case 'SMS':?>
	   
   

	<?php
   
include('report_status_sms.php');

    
?>
<?php
          
		    break;
       case 'REMIT':?>
	   
   

	<?php
   
include('report_status_remit.php');

    
?>
<?php
          
		    break;
       case 'MISSCALLALERTSERVICE':?>
	   
   

	<?php
   
include('report_status_miss_call.php');

    
?>
<?php
          
		    break;
       case 'FRAUDALERTSERVICE':?>
	   
   

	<?php
   
include('report_status_fraud.php');

    
?>
<?php
          
		    break;
       case 'ALL':?>
	   
   

	<?php
   
include('report_status_all.php');

    
?>

<?php
	    break;
        default:
            echo 'NO Channel Selected';
            break;
    }
}
?>
