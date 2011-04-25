<?php
session_start();
include("db_conn.php");
$mn_id=$_SESSION['resource_mn_id'];
$image_id=$_SESSION['resource_image_id'];

//echo $mn_id;
//echo $image_id;
$result=mysql_query("SELECT prettyname from mn_image where mn_id='$mn_id' and image_id='$image_id' ");	
$imagename=mysql_fetch_row($result);
//$num=mysql_num_rows($result);
//echo "Num: ".$num;
echo "Image Name: ".$imagename['0']." on Management Node ".$mn_id."<br>";
echo "<br><hr><br>";
//------------cpuidle_time-------------------

echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select cpu_idle from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=CPU+Idle+Time' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=CPU+Idle+Time' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}		


//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Idle Time</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------


//------------cpupeak------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select cpu_peak from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=CPU+Peak' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=CPU+Peak' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: CPU Peak</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------
//------------cpuloadavg---------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select cpu_loadavg from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=CPU+Load+Average' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=CPU+Load+Average' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: CPU Load Average</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------
//------------memsize------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select mem_size from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=Memory+Size' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Memory+Size+in+MB' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Memory Size</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------memfree------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select mem_free from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=Memory+Free' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Memory+Free+in+MB' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Memory Free</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------memused------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select mem_used from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=Memory+Used' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Memory+Used+in+MB' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Memory Used</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------mempeakused--------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select mem_peak_used from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=Peak+Memory+Used' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Peak+Memory+Used+in+MB' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Peak Memory Used</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------ioreads------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select io_block_reads from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=I/O+Block+Reads' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=I/O+Block+Reads+per+second' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: I/O Reads</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------iowrites-----------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select io_block_writes from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=I/O+Block+Reads' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=I/O+Block+Writes+per+second' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	


//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: I/O Writes</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------eth0rx-------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select eth0_rx from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth0+Received+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=On+eth0+Received+in+MegaBytes' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: MBs received on eth0</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------eth0tx-------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select eth0_tx from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth0+Transmitted+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=On+eth0+Transmitted+in+MegaBytes' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: MBs transmitted on eth0</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------eth1rx-------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select eth1_rx from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth1+Received+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=On+eth1+Received+in+MegaBytes' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: MBs received on eth1</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//------------eth1tx-------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select eth1_tx from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth1+Transmitted+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=On+eth1+Transmitted+in+MegaBytes' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: MBs transmitted on eth1</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//-----------------------------------paging faults-----------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select paging_faults from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
$curr_row=1;
$max=-1;
$no_of_rows = mysql_num_rows($result);
while($curr_row <= $no_of_rows) {
$count = mysql_fetch_row($result);	
if($curr_row < $no_of_rows){  
 		echo ($count['0']/1000).",";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo ($count['0']/1000); 		
 		}		

	if($max < ($count['0']/1000)){
 			$max = ($count['0']/1000);	
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth1+Transmitted+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Peak+Paging+Faults+per+second' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Number of Page Faults</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------

//-----------------------------------peaktcp_connections---------------------------------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select peak_num_TCP_conn from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth1+Transmitted+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Number+of+TCP+Connections' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Peak number of TCP connections</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------
//------------------------------------------fs_root_used-----------------------------------------------
echo "<table><tr><td>";

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";
$result=mysql_query("select fs_root_used from mn_dyn_info where mn_id='$mn_id' AND image_id='$image_id' ");
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

$mid = $max/2; 
echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
if( $max < $limit ){
echo "&chtt=eth1+Transmitted+Bytes' width='300' height='225' alt='CPU Idle Time'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Percentage+of+times+Root+filesystem+used' width='300' height='225' alt='CPU Idle Time'  style='float:center' />";	
}	

//-----------Key-------------------------------------------------

$key=mysql_query("select L.start from mn_log as L, mn_dyn_info as D 
					where L.mn_id='$mn_id' AND L.image_id='$image_id' AND D.mn_id='$mn_id' AND D.image_id='$image_id' 
					AND L.mn_id=D.mn_id AND L.image_id=D.image_id AND L.log_id=D.log_id ORDER BY L.log_id" );
$i=1;
echo "</td><td><table border='1'><tr><th colspan='2'>X-Axis: Time of Reservation</th></tr>";
echo "<tr><th colspan='2'>Y-Axis: Number of times filesystem<br> root access used</th></tr>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($key_result=mysql_fetch_array($key))) {					
echo "<tr><td>".$i."</td><td>Reservation@".$key_result['0']."</td></tr>";
$i++;
}
echo "</table></td></tr></table>";
echo "<br><hr><br>";
//----------------------------------------------------------------






?>