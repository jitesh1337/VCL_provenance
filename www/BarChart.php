<html>
<body>
<?php
echo "<p>Hello World</p>";

$con = mysql_connect("localhost:3306","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("test", $con);

$result = mysql_query("SELECT * FROM bartest");
$rows = mysql_num_rows($result);
echo "Rows: ".$rows;
$curr_row = 1;

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
 	
 		$curr_row = $curr_row + 1;
  }
 
echo "&chtt=Vertical+bar+chart' width='300' height='300' alt='Vertical bar chart' />";
//echo "</table>";

mysql_close($con);

?>
</body>
</html>




