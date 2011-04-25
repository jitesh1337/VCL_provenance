<?php
session_start();
//echo $_SESSION['mn_id'];

include("db_conn.php");

$mn_id=$_SESSION['mn_id'];
$log_id=$_SESSION['log_id'];

/*
echo "MN_ID: ".$_SESSION['mn_id'];
echo " LOG_ID: ".$_SESSION['log_id'];
*/

$result=mysql_query("SELECT * from mn_dyn_info where mn_id='$mn_id' AND log_id='$log_id' ");
$imagename=mysql_query("SELECT i.prettyname from mn_image as i, mn_reservation as r where 
											r.mn_id='$mn_id' AND r.log_id='$log_id' AND i.image_id=r.image_id AND i.mn_id='$mn_id' "); 

if(($numrows=mysql_num_rows($result))==0)
{
	echo "<h1 style='font-family:Lucida Console'><span style='color:red'>No Information currently Available.</span></h1>";	
}
else {
$image=mysql_fetch_row($imagename);										
echo "<h1 style='font-family:Lucida Console'>Image Name: <span style='color:red'><u> ".$image['0']."</u></span></h1><br>";										
echo "<table border='1' cellspacing='4' cellpadding='4'>";
while($rows=mysql_fetch_array($result)) {
echo "<tr><th>No. of CPU Cores: </th><td>".$rows['4']."</td></tr>";
echo "<tr><th>CPU Idle Time: </th><td>".$rows['5']."</td></tr>";
echo "<tr><th>Peak CPU Time: </th><td>".$rows['6']."</td></tr>";
echo "<tr><th>CPU Load Average: </th><td>".$rows['7']."</td></tr>";
echo "<tr><th>Memory Size: </th><td>".($rows['8']/1000)." MB</td></tr>";
echo "<tr><th>Free Memory: </th><td>".($rows['9']/1000)." MB</td></tr>";
echo "<tr><th>Memory Used: </th><td>".($rows['10']/1000)." MB</td></tr>";
echo "<tr><th>Memory Peak Used: </th><td>".($rows['11']/1000)." MB</td></tr>";
echo "<tr><th>I/O Block Reads: </th><td>".$rows['12']." Blocks/sec</td></tr>";
echo "<tr><th>I/O Block Writes: </th><td>".$rows['13']." Blocks/sec</td></tr>";
echo "<tr><th>Bytes Received on eth0: </th><td>".($rows['14']/1000)." MB</td></tr>";
echo "<tr><th>Bytes Transmitted on eth0: </th><td>".($rows['15']/1000)." MB</td></tr>";
echo "<tr><th>Bytes Received on eth1: </th><td>".($rows['16']/1000)." MB</td></tr>";
echo "<tr><th>Bytes Transmitted on eth1: </th><td>".($rows['17']/1000)." MB</td></tr>";
echo "<tr><th>Paging Faults: </th><td>".($rows['19']/1000000)." X 10<sup>6</sup></td></tr>";
echo "<tr><th>Peak Number of TCP Connections: </th><td>".$rows['20']." </td></tr>";
echo "<tr><th>Percentage of Root File system Used: </th><td>".$rows['21']." times</td></tr>";
}
echo "</table>";
}
//session_destroy();
?>