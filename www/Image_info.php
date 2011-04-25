<?php session_start(); ?>
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
document.getElementById('Images').innerHTML=xmlHttp.responseText;
setTimeout('Ajax()',2000);
}
}


xmlHttp.open("GET","images.php",true);

xmlHttp.send(null);

}

window.onload=function(){
setTimeout('Ajax()',3000);
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
   			<div id="Images">
   			<?php
   			echo "<table><tr><td>";
					echo "<img src='images/loading_ajax.gif' alt='Loading' align='center'></tr></td></table>";
   			?>
   			</div>    
	
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com"></a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
