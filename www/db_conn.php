<?php
$con = mysql_connect("localhost:3306","root","sm3");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("provenance", $con);


?>