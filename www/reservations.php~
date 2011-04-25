<html>
<?php
include("db_conn.php");
echo "<h1><u>The Reservation Analysis Graphs</u></h1><br>";
$curr_row = 1;
$max = -1;
$limit = 0;
$width = 50;
//$i=1;
for ( $i=1; $i<=3; $i++ ) {
$curr_row = 1;
$max = -1;
$limit = 0;
$width = 50;	
$result = mysql_query("SELECT m.image_id,m.name FROM mn_image AS m WHERE m.mn_id=$i ");
$no_of_rows = mysql_num_rows($result);
//echo $no_of_rows;
echo "<table><tr><td>";
echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=400x300&cht=bvg&chco=A2C180,3D7930";
/*
while($curr_row <= $no_of_rows) {
if($curr_row < $no_of_rows){  
 		echo $curr_row."|";
 		}
 		elseif($curr_row==$no_of_rows) {
		echo $curr_row; 		
 		}		
$curr_row++;
}
*/
$curr_row=1;
echo "&chd=t:";

while($curr_row <= $no_of_rows) {
$row=mysql_fetch_row($result);
$imageid = $row['0'];	
$res = mysql_query("SELECT COUNT(image_id) FROM mn_reservation WHERE mn_id=$i AND image_id=$imageid");
$count = mysql_fetch_row($res);		
//echo $count['0'];

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
echo "||1:|0|".$mid."|".$max;
if( $max < $limit ){
echo "&chtt=At+Management+Node+".$i." width='400' height='300' alt='At Management Node".$i."'style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=At+Management+Node+".$i."' width='400' height='300' alt='At Management Node".$i."'  style='float:center' />";	
}

//echo "&chtt=Vertical+bar+chart' width='300' height='225' alt='Vertical bar chart'  style='float:center' />";
echo "</td><td>";
$curr_row=1;
$result = mysql_query("SELECT m.prettyname FROM mn_image AS m WHERE m.mn_id=$i ");
echo "<p align='left'><table border='1' style='border:dotted 2px #060'>";
echo "<tr><th colspan='2'>Graph Key</th></tr>";
while(($row=mysql_fetch_array($result))) {
echo "<tr><td>".$curr_row."</td><td>".$row['0']."</tr>";
$curr_row++;
}
echo "</table></p></td></tr></table>";
echo "<br><br><br><hr /><br>";

}


/*
$rows = mysql_num_rows($result);
echo "Rows: ".$rows;
$curr_row = 1;
$max = -1;
$limit = 100;
$width = 50;

echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=300x225&cht=bvg&chco=A2C180,3D7930&chd=t:";

//echo "Here1 ";

while($curr_row<=$rows) 
  {
 		//echo "Here ".$curr_row;
  		$row =  mysql_fetch_row($result);	  
		if($curr_row < $rows){  
 		echo $row['1'].",";
 		}
 		elseif($curr_row==$rows) {
		echo $row['1']; 		
 		}		
		 		
 		if($max < $row['1']){
 			$max = $row['1'];	
 		}
 		
 		$curr_row = $curr_row + 1;
  }
 
if( $max < $limit ){
echo "&chtt=Vertical+bar+chart' width='300' height='225' alt='Vertical bar chart'  style='float:center' />";
}
else {
echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Vertical+bar+chart' width='300' height='225' alt='Vertical bar chart'  style='float:center' />";	
}
//echo "</table>";
*/
mysql_close($con);

?>
</html>
