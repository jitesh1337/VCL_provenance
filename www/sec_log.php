<?php
include("db_conn.php");

$severity=$_GET['severity'];
//echo "$severity";

echo "<h1 style='font-family:Lucida Console'><u>Security Log<u></h1><br>";

for ( $i=1; $i<=3; $i++ ) {

	echo "<table cellpadding='4' border='1'>";
	$result = mysql_query("select log_id from mn_sec_log where mn_id=$i group by log_id");
	echo "<tr><th>Management Node: </th><th colspan='2' align='left'> ".$i."</th></tr>";

	while(($row=mysql_fetch_array($result))) {

		if ($row['0'] != 0) {

			$i_result = mysql_query("select i.name from mn_image i, mn_log ml where ml.log_id=".$row['0']." and ml.image_id=i.image_id");
			$i_row = mysql_fetch_array($i_result);
			echo "<tr><th>Image Name: </th><th colspan='2' align='left'> ".$i_row['0']."</th></tr>";
		
			$l_id=$row['0'];
			$l_result = mysql_query("select daemon_name, log_line from mn_sec_log where mn_id=$i and log_id=$l_id and severity<=$severity order by sec_log_id desc");
			while (($l_row=mysql_fetch_array($l_result))) {
				echo "<tr>";	
				echo "<td align='center'>".$l_row['0']."</td><td align='center'>".$l_row['1']."</td>";
				echo "</tr>";
			}
		}
		else {

			$l_result = mysql_query("select daemon_name, log_line from mn_sec_log where mn_id=$i and log_id=0 order by sec_log_id desc");
			while (($l_row=mysql_fetch_array($l_result))) {
				echo "<tr>";	
				echo "<td align='center'>".$l_row['0']."</td><td align='center'>".$l_row['1']."</td>";
				echo "</tr>";
			}

		}
	}

	echo "</table>";
	echo "<br><br>";
}

mysql_close($con)

?>
