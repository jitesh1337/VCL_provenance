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
document.getElementById('UserEvents').innerHTML=xmlHttp.responseText;
setTimeout('Ajax()',2000);
}
}


xmlHttp.open("GET","get_security_events.php",true);

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
                    <li><a href="Image_info.php">Image Profiles</a></li>
                    <li><a href="Reservations.php">Active Reservations</a></li>
                    <li><a href="#">SM-3 Team</a></li>
                </ul>
</div>       
                
              <div id="leftmenu_bottom"></div>
        </div>
        
        
        
        
		<div id="content">
        
        
        <div id="content_top"></div>
        <div id="content_main">
   			<div id="UserEvents">
   			<?php		
					include("db_conn.php");
					
					$mn_id=$_GET['mn_id_user'];
					$user_id=$_GET['user_id'];
										
					$result=mysql_query("select unityid from mn_user where mn_id='$mn_id' AND user_id='$user_id' ");
					$username=mysql_fetch_row($result);
					$_SESSION['event_unityid']=$username['0'];
					$_SESSION['event_mn_id']=$mn_id;
					$_SESSION['event_user_id']=$user_id;
					echo "<table><tr><td>";
					echo "<img src='images/loading_ajax.gif' alt='Loading' align='center'></tr></td></table>";

				?>
   			</div>    
			<p><a href="user_security_events.php" >Back</a></p>
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com">florida web design</a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>
