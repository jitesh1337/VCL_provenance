<html>
<title>Welcome to Provenance.</title>


<?php


$con = mysql_connect("localhost:3306","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("vcl", $con);

$result = mysql_query("SELECT * FROM state");

echo "<table border='1'>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";	  
  echo "<td>".$row['id'] . "</td><td>" . $row['name']. "</td>";
  echo "</tr>";
  }

echo "</table>";

mysql_close($con);

?>



</html>