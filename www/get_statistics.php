<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Team SM-3 Provenance</title>
</head>

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
				<?php
					//session_start();
					include("db_conn.php");
					$startmonth = $_SESSION['start_month'] = $_GET['start_month'];
					$startday = $_SESSION['start_day'] = $_GET['start_day'];
					$startyear = $_SESSION['start_year'] = $_GET['start_year'];
					$endmonth = $_SESSION['end_month'] = $_GET['end_month'];
					$endday = $_SESSION['end_day'] = $_GET['end_day'];
					$endyear = $_SESSION['end_year'] = $_GET['end_year'];
					
					//echo $endday;
					/*
					$result=mysql_query("SELECT STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y')");
					$rows=mysql_fetch_row($result);
					echo "Date: ".$rows['0'];
					*/
					$mn_id=1;
					for($mn_id=1; $mn_id<=3; $mn_id++) {
					echo "<table cellpadding='4'><tr><td>";
					
					echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=400x225&cht=bvg&chco=AA0000,3D7930&chd=t:";
					//Per mn per image number of reservations-- Calculate total of images first
					$total_images_query=mysql_query("SELECT image_id from mn_image where mn_id='$mn_id' ");
					$total_image_count=-1;
					while(($total_images=mysql_fetch_array($total_images_query)))
					{
						if($total_image_count < $total_images['0'] ){
						$total_image_count=$total_images['0'];
						}
					}
					$curr_row=1;
					$max=-1;
					//$no_of_rows = mysql_num_rows($result);
					
					while($curr_row <= $total_image_count){
					$data=0;
					$result=mysql_query("SELECT COUNT(image_id), image_id
					FROM mn_log where mn_id='$mn_id' AND DATE(start) < STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y')
									AND DATE(start) > STR_TO_DATE(' $startday , $startmonth , $startyear','%d,%m,%Y') 
									OR (DATE(start)=STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y')	
									OR DATE(start)=STR_TO_DATE(' $startday , $startmonth , $startyear','%d,%m,%Y'))			
									GROUP BY mn_id,image_id");
						
					while(($count=mysql_fetch_array($result))) {
						//echo "Hour: ".$count['1']."Curr_row: ".$curr_row."<br> ";
						if($count['1'] == $curr_row) {
						//echo "Inhere";		
						$data=$count['0'];
						break;
						}	
					}	
						
						$count = mysql_fetch_row($result);	
					if($curr_row < $total_image_count){  
					 		echo $data.",";
					 		}
					 		elseif($curr_row==$total_image_count) {
							echo $data; 		
					 		}	
					
						if($max < $data){
					 			$max = $data;	
					 		}
					 	
					$curr_row++;	
						
						}
					
					echo "&chxt=x,y&chxl=0:|";
					$curr_row=1;
					while($curr_row <= $total_image_count) {
					if($curr_row < $total_image_count){  
					 		echo $curr_row."|";
					 		}
					 		elseif($curr_row==$total_image_count) {
							echo $curr_row; 		
					 		}		
					$curr_row++;
					}
					if(($max % 2) != 0){
					$max++;
					}
					$mid = $max/2; 
					echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
					echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=On+Management+Node+".$mn_id." ' width='400' height='225' alt='CPU Idle Time'  style='float:center' />";	
							
					echo "</td><td><table>";
					$curr_row=1;
					$images_key = mysql_query("SELECT m.prettyname, m.image_id FROM mn_image AS m WHERE m.mn_id=$mn_id ");
					echo "<p align='left'><table border='1' style='border:dotted 2px #060'>";
					echo "<tr><th colspan='2'>X-Axis: Images</th></tr>";
					echo "<tr><th colspan='2'>Y-Axis: Number of Reservations</th></tr>";
					echo "<tr><th colspan='2'>Graph Key</th></tr>";
					while(($row=mysql_fetch_array($images_key))) {
					echo "<tr><td>".$row['1']."</td><td>".$row['0']."</tr>";
					$curr_row++;
					}
					echo "</table></td></tr></table>";
					
					echo "<br><br><hr><br><br>";
					}
					//--------------------------------------------------Reservations By Day-----------------------------------------------------------------
					
					echo "<img src='http://chart.apis.google.com/chart?chxt=y&chbh=a&chs=700x225&cht=bvg&chco=AA0000,3D7930&chd=t:";
					//$result=mysql_query("SELECT COUNT(HOUR(start)), HOUR(start)
					//							FROM mn_log where DATE(start) < STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y') GROUP BY HOUR(START) ");
					$curr_row=0;
					$max=-1;
					$no_of_rows = mysql_num_rows($result);
					$required_rows=23;
					//echo $no_of_rows."  ";
					
					
					while($curr_row <= $required_rows) {
					$result=mysql_query("SELECT COUNT(HOUR(start)), HOUR(start) FROM mn_log 
												where DATE(start) < STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y') 
												AND DATE(start) > STR_TO_DATE(' $startday , $startmonth , $startyear','%d,%m,%Y') 
												OR (DATE(start)=STR_TO_DATE(' $endday , $endmonth , $endyear','%d,%m,%Y')	
												OR DATE(start)=STR_TO_DATE(' $startday , $startmonth , $startyear','%d,%m,%Y'))	
												GROUP BY HOUR(START) ");	
					$data=0;	
					while(($count=mysql_fetch_array($result))) {
						//echo "Hour: ".$count['1']."Curr_row: ".$curr_row."<br> ";
						if($count['1'] == $curr_row) {
						//echo "Inhere";		
						$data=$count['0'];
						break;
						}	
					}	
					
						if($curr_row < $required_rows){  
					 		echo $data.",";
					 		}
					 		elseif($curr_row==$required_rows) {
							echo $data; 		
					 		}		
					
						if($max < $data){
					 			$max = $data;	
					 		}
					 	
					$curr_row++;
					
					}
					
					echo "&chxt=x,y&chxl=0:|";
					$curr_row=0;
					while($curr_row <= $required_rows) {
					if($curr_row < $required_rows){  
							if($curr_row<13) {
					 				echo $curr_row."am|";
								} 		
								else {
									echo ($curr_row-12)."pm|";
									}
					 		}
					 		elseif($curr_row==$required_rows) {
							echo ($curr_row-12)."pm"; 		
					 		}		
					$curr_row++;
					}
					if(($max % 2) != 0){
					$max++;
					}
					$mid = $max/2; 
					echo "||1:|0|".($mid/2)."|".$mid."|".(0.75*$max)."|".$max;
					echo "&chxr=0,0,".$max."&chds=0,".$max."&chtt=Reservations+By+Hour' width='659' height='225' alt='CPU Idle Time'  style='float:center' />";	
					
					
					?>
				<br><br><hr><a href="Home.php" >Back</a>						
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com"></a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
