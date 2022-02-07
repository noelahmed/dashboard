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
<table width="100%" align="center"  id="customers">
			
			<tr>
			
			<td>
            <font size="+1" color="#00FF66"> <B>ACCESS BY DIA</B></font>
            <?php include"total_otp.php"?>
		   </td>
			 <td>
			<font size="+1" color="#00FF66"> <B>MOBILE TOPUP BY DIA</B></font>
            <?php include"total_dia.php"?>

  
             </td>
		
	</tr>
			
			
			</table>
			
                    