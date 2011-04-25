<?php session_destroy(); session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Team SM-3 Provenance</title>
</head>
<script type="text/javascript">

//--------------------------------------------------------------------------------

function ShowUsers(str)
{
	//alert("CAlled Function" + str);
if (str=="")
  {
  document.getElementById("users").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 || xmlhttp.status==200)
    {
    document.getElementById("users").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","user_drop_down.php?mn_id_user="+str,true);
xmlhttp.send();
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
        <?php //echo "Session check: ".$_SESSION['mn_id']; ?>
        <form method="GET" action="show_security_events.php">
   		<?php
   		include("db_conn.php");
   		echo "<table><tr><td>Select the Management Node:</td><td><select name='mn_id_user' onchange='ShowUsers(this.value)'>";
   		echo "<option value=''></option>";
   		$result=mysql_query("SELECT mn_id from mn_info");
   		while(($row=mysql_fetch_array($result))) {
			echo "<option value='".$row['0']."'>".$row['0']."</option>";
			}   		
   		echo "</select></td></tr>";
   		?>	  
			<tr><td>User ID:</td><td>   		
			<div id="users"></div>
				</td></tr>	
				<tr><td><input type="submit"></td></tr>				
				
				</table>
			
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com"></a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
