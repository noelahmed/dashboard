<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Connection</title>
</head>

<body>

<?php
$DBHOST = '192.168.225.36';
$DB_USER_NAME = 'dashboard';
$DB_PASSWORD = 'dashboard';
$DB_NAME = 'eblconnect';

$connect=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");
if (!$connect)
  {
  die("Connection error: " . mysqli_connect_error());
  }
  
/*
$DBHOST = '192.168.3.54';
$DB_USER_NAME = 'eblconnect';
$DB_PASSWORD = 'Ebl_123@';
$DB_NAME = 'eblconnect';

$connection_db=mysqli_connect("$DBHOST","$DB_USER_NAME","$DB_PASSWORD","$DB_NAME");
if (!$connection_db)
  {
  die("Connection error: " . mysqli_connect_error());
  }
*/

?>


</body>
</html>
