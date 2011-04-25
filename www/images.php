<?php
include("db_conn.php");
echo "<h1 style='font-family:Lucida Console'><u>MANAGEMENT NODE PROFILES<u></h1><br>";
for ( $i=1; $i<=3; $i++ ) {
$total_reservations = 0;	
echo "<table cellpadding='4' border='1'>";

$result = mysql_query("SELECT mn_public_ip FROM mn_info WHERE mn_id=$i");
$row = mysql_fetch_array($result);

echo "<tr><th>Machine IP Address: </th><th colspan='2' align='left' ><span style='color:red'> ".$row['0']."</span></th>";

echo "<tr><th>Management Node: </th><th colspan='2' align='left'> ".$i."</th>";

$result = mysql_query("SELECT m.prettyname,m.datecreated,m.lastupdate,m.image_id FROM mn_image AS m WHERE m.mn_id=$i ");



echo "<tr><th><u>Image Name</u></th><th><u>Date Created</u></th><th><u>Last Updated</u></th><th><u># Reservations</u></th></tr>";
while(($row=mysql_fetch_array($result))) {
$imageid = $row['3'];	
$res = mysql_query("SELECT COUNT(image_id) FROM mn_reservation WHERE mn_id=$i AND image_id=$imageid");
$count = mysql_fetch_row($res);	
$total_reservations=$count['0']+$total_reservations;
echo "<tr>";	
echo "<td>".$row['0']."</td><td align='center'>".$row['1']."</td><td align='center'>".$row['2']."</td><td><b>".$count['0']."</b>
 Reservations</td>";
echo "</tr>";
}
echo "<tr><th>Total Reservations:</th><td colspan='3' align='center'><span style='color:red'><b>".$total_reservations."</b></span>
</td></tr>";
echo "</table>";

echo "<br><hr /><br>";
}
mysql_close($con);


?>