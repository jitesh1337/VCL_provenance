<?php
session_start();
include("db_conn.php");
$mn_id=$_SESSION['event_mn_id'];
$user_id=$_SESSION['event_user_id'];
$unityid=$_SESSION['event_unityid'];
/*
$result=mysql_query("select COUNT(s.sec_log_id), l.start from mn_sec_log as s, mn_log as l WHERE
						l.mn_id='$mn_id' AND l.user_id='$user_id' AND s.mn_id='$mn_id' AND
						l.log_id=s.log_id GROUP BY s.log_id ");
$num=mysql_num_rows($result);
echo "Number: ".$num."<br>";
while(($rows=mysql_fetch_array($result))) {
echo $rows['0']."   :   ".$rows['1']."<br> ";
}
*/
//-------------------------------Graph------------------------------------------------------------------------------------

echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";

$result=mysql_query("select COUNT(s.sec_log_id), l.start from mn_sec_log as s, mn_log as l WHERE
						l.mn_id='$mn_id' AND l.user_id='$user_id' AND s.mn_id='$mn_id' AND
						l.log_id=s.log_id GROUP BY s.log_id ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo $count['0'].",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo $count['0']; 		
 		}		

	if($max < $count['0']){
 			$max = $count['0'];	
 		}
 	
$curr_row++;
}

echo "&chxt=x,y&chxl=0:|";
$curr_row=1;
while($curr_row <= $no_of_rows) {
if($curr_row < $no_of_rows){  
 		echo $curr_row."|";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo $curr_row; 		
 		}		
$curr_row++;
}

if($max % 2 != 0)
{
$max++;	
}
$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=CPU+Idle+Time' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Security+Events+for+".$unityid."+on+Node+".$mn_id."' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}		


//-----------Key-------------------------------------------------

$key=mysql_query("select l.start from mn_sec_log as s, mn_log as l WHERE
						l.mn_id='$mn_id' AND l.user_id='$user_id' AND s.mn_id='$mn_id'  
							 AND 	l.log_id=s.log_id GROUP BY s.log_id ");
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Number of Security Events</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Login @ ".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------








?>