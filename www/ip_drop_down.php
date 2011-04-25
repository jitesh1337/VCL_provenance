<?php
include("db_conn.php");
$mn_id=$_GET['mnid'];
	
	$result_log=mysql_query("SELECT DISTINCT c.ip_address, r.log_id  FROM mn_computer as c, mn_reservation as r
	 WHERE r.mn_id='$mn_id' AND c.mn_id='$mn_id' AND c.computer_id=r.computer_id ORDER BY r.log_id");	
echo "<select name='log_id'> ";

	while($row=mysql_fetch_array($result_log)) {
	echo "<option value=' ". $row['1'] ." '>".$row['0']."</option>";
	}					
	
echo "</select>";
?>