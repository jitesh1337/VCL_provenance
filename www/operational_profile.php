<?php session_destroy();  session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Team SM-3 Provenance</title>
</head>
<script type="text/javascript">

function Ajax(){
var xmlHttp;
try{
xmlHttp=new XMLHttpRequest();// Firefox, Opera 8.0+, Safari

}
catch (e){
try{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
}
catch (e){
try{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");

}
catch (e){
alert("No AJAX!?");
return false;
}
}
}

xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState==4){
document.getElementById('Image_Info').innerHTML=xmlHttp.responseText;
setTimeout('Ajax()',2000);
}
}


xmlHttp.open("GET","next_op_profile.php",true);

xmlHttp.send(null);

}

window.onload=function(){
setTimeout('Ajax()',1000);
}


</script>
<body>
<div id="container">
		<div id="header">
        	<h1>SM-3<span class="off">Provenance</span></h1>
            <h2>CSC-591 : Cloud Computing</h2>
        </div>   
          <div id="menu">
        	<ul>
            	<li class="menuitem"><a href="Home.php">Home</a></li>
                <li class="menuitem"><a href="#">About</a></li>
                <li class="menuitem"><a href="resource_allocation.php">Resource Allocation</a></li>
                <li class="menuitem"><a href="image_operational_profile.php">Operational Profile</a></li>
                <li class="menuitem"><a href="Statistics.php">Statistics</a></li>
                <li class="menuitem"><a href="user_security_events.php">User Security</a></li>
              <li class="menuitem"><a href="logs.php">Failure and Security Logs</a></li>
            </ul>
        </div>
        
        <div id="leftmenu">

        <div id="leftmenu_top"></div>

				<div id="leftmenu_main">    
                
                <h3>Links</h3>
                        
                <ul>
                    <li><a href="Image_info.php">Management Node Profiles</a></li>
                    <li><a href="Reservations.php">Active Reservations</a></li>
                    <li><a href="#">SM-3 Team</a></li>
                </ul>
</div>            
                
              <div id="leftmenu_bottom"></div>
        </div>
        
        
        
        
		<div id="content">
        
        
        <div id="content_top"></div>
        <div id="content_main">
   			<div id="Image_Info">
   			<?php		
					include("db_conn.php");
					
					$mn_id=$_GET['mn_id'];
					$log_id=$_GET['log_id'];
					
					$_SESSION['mn_id']=$mn_id;
					$_SESSION['log_id']=$log_id;
					echo "<table><tr><td>";
					echo "<img src='images/loading_ajax.gif' alt='Loading' align='center'></tr></td></table>";
					//echo "Session check: ".$_SESSION['mn_id'];	
								
					/*
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
					echo "<table border='1' cellspacing='4' cellpadding='4>";
					while($rows=mysql_fetch_array($result)) {
					echo "<tr><th>No. of CPU Cores: </th><td>".$rows['4']."</td></tr>";
					echo "<tr><th>CPU Idle Time: </th><td>".$rows['5']."</td></tr>";
					echo "<tr><th>Peak CPU Time: </th><td>".$rows['6']."</td></tr>";
					echo "<tr><th>CPU Load Average: </th><td>".$rows['7']."</td></tr>";
					echo "<tr><th>Memory Size: </th><td>".($rows['8']/1000)." MB</td></tr>";
					echo "<tr><th>Free Memory: </th><td>".($rows['9']/1000)." MB</td></tr>";
					echo "<tr><th>Memory Used: </th><td>".($rows['10']/1000)." MB</td></tr>";
					echo "<tr><th>I/O Block Reads: </th><td>".$rows['11']." </td></tr>";
					echo "<tr><th>I/O Block Writes: </th><td>".$rows['12']." </td></tr>";
					echo "<tr><th>Bytes Received on eth0: </th><td>".$rows['13']." Bytes</td></tr>";
					echo "<tr><th>Bytes Transmitted on eth0: </th><td>".$rows['14']." Bytes</td></tr>";
					}
					echo "</table>";
					}
					*/
				?>
   			</div>    
			<p><a href="image_operational_profile.php" >Back</a></p>
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com"></a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
