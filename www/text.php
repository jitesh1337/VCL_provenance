<?php
$con = mysql_connect("localhost:3306","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("test", $con);

$query = "select comments from Comments"

$result = mysql_query($query);

while($row=mysql_fetch_array($result)) {
			
			echo $row['comments'];
	}

mysql_close($con);


?>