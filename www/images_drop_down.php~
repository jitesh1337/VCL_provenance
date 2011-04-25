<?php
include("db_conn.php");
$mn_id=$_GET['mnid'];
//$result=mysql_query("SELECT mn_id, log_id FROM mn_reservation WHERE mn_id='$mn_id'");
//$norows=mysql_num_rows($result);
//echo $norows."<br>";
	
	$result_log=mysql_query("SELECT prettyname, image_id from mn_image where mn_id='$mn_id' ORDER BY image_id ASC ");	
echo "<select name='image_id'> ";

	while($row=mysql_fetch_array($result_log)) {
	echo "<option value=' ". $row['1'] ." '>".$row['0']."</option>";
	}					
	
echo "</select>";
