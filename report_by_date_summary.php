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
   
			<form method = "post" action="report_status_summary.php"  >
						
	<table border=1 width="30%" id="customers" align="center">
	
		<tr><TD><h2 align="center">SUMMARY REPORT</h2></TD><TD><img src="ebl_logo.jpg" width="131" height="116" /></TD><tr>
               
<TR>
<TD align=center>CHANNELS</TD>
                <TD align=center><select name="status" >
			<option value="SKYBANKING">SKYBANKING</option>
			<option value="INTERNETBANKING">INTERNET BANKING</option>
			<option value="EBLCONNECT">EBL CONNECT</option>
			<option value="EBLDIA">EBL  DIA</option>
			<option value="REMIT">REMIT API</option>
			<option value="SMS">EBL SMS</option>
			<option value="MISSCALLALERTSERVICE">MISS CALL ALERT SERVICE</option>
			<option value="FRAUDALERTSERVICE">FRAUD ALERT SERVICE</option>
			<option value="ALL">ALL CHANNELS</option>
			
		
</select> </TD></TR>
<TR>
			   <TD align=center>PLEASE SELECT FROM DATE:</TD>
                <TD align="center"><LINK href="js\jquery-ui.css" rel="stylesheet">
	<SCRIPT src="js\jquery.min.js"></SCRIPT>
   
<SCRIPT src="js\jquery-ui.min.js"></SCRIPT>
       
<SCRIPT>
$(document).ready(function(){
    $('#datepicker').datepicker(
	{
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
	});


});
  </SCRIPT>
</head>
<body><INPUT id="datepicker" size=22 name=datepicker ></TD>
</TR>
<TR>
			   <TD align=center>PLEASE SELECT TO DATE:</TD>
                <TD align="center">
       
<SCRIPT>
$(document).ready(function(){
    $('#datepicker1').datepicker(
	{
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
	});


});
  </SCRIPT>
</head>
<body><INPUT id="datepicker1" size=22 name=datepicker1 ></TD>
</TR>
				
               <TR>
			   <td align="center">
                           
                        <td align="center">
                           <input name = "update" type = "submit" 
                              id = "update" value = "Show"  ></td></TR>
                        </td>
						</TR>
						</TABLE>
						
						
		
		
                     
				</FORM>

 </div>
    <br class="clear" />
  </div>
</div>

<!-- ####################################################################################################### -->

<!-- ####################################################################################################### -->

</body>
</html>
