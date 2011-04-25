<?php
include("db_conn.php");
$mn_id=1;//$_GET['mn_id_user'];
//$result=mysql_query("SELECT mn_id, log_id FROM mn_reservation WHERE mn_id='$mn_id'");
//$norows=mysql_num_rows($result);
//echo $norows."<br>";
	
	$result_user=mysql_query("SELECT user_id, unityid from mn_user where mn_id='$mn_id' ORDER BY user_id");	
echo "<select name='user_id'> ";

	while($row=mysql_fetch_array($result_user)) {
	echo "<option value=' ". $row['0'] ." '>".$row['1']."</option>";
	}					
	
echo "</select>";
?>