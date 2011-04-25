<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Team SM-3 Provenance</title>
</head>
<script type="text/javascript">

function Ajax(){
var xmlHttp, xmlHttp1,xmlHttp2, xmlHttp3, xmlHttp4, xmlHttp5;
try{
xmlHttp=new XMLHttpRequest();// Firefox, Opera 8.0+, Safari
xmlHttp1=new XMLHttpRequest();
xmlHttp2=new XMLHttpRequest();
xmlHttp3=new XMLHttpRequest();
xmlHttp4=new XMLHttpRequest();
xmlHttp5=new XMLHttpRequest();

}
catch (e){
try{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
xmlHttp2=new ActiveXObject("Msxml2.XMLHTTP"); 
xmlHttp3=new ActiveXObject("Msxml2.XMLHTTP"); 
xmlHttp4=new ActiveXObject("Msxml2.XMLHTTP"); 
xmlHttp5=new ActiveXObject("Msxml2.XMLHTTP"); 
}
catch (e){
try{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
xmlHttp2=new ActiveXObject("Microsoft.XMLHTTP");
xmlHttp3=new ActiveXObject("Microsoft.XMLHTTP");
xmlHttp4=new ActiveXObject("Microsoft.XMLHTTP");
xmlHttp5=new ActiveXObject("Microsoft.XMLHTTP");

}
catch (e){
alert("No AJAX!?");
return false;
}
}
}

xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState==4){
document.getElementById('Chart_1').innerHTML=xmlHttp.responseText;
//setTimeout('Ajax()',2000);
}
}

xmlHttp1.onreadystatechange=function(){
if(xmlHttp1.readyState==4){
document.getElementById('Chart_2').innerHTML=xmlHttp1.responseText;
//setTimeout('Ajax()',2000);
}
}

xmlHttp2.onreadystatechange=function(){
if(xmlHttp2.readyState==4){
document.getElementById('Chart_3').innerHTML=xmlHttp2.responseText;
//setTimeout('Ajax()',2000);
}
}

xmlHttp3.onreadystatechange=function(){
if(xmlHttp3.readyState==4){
document.getElementById('Chart_4').innerHTML=xmlHttp3.responseText;
//setTimeout('Ajax()',2000);
}
}

xmlHttp4.onreadystatechange=function(){
if(xmlHttp4.readyState==4){
document.getElementById('Chart_5').innerHTML=xmlHttp4.responseText;
//setTimeout('Ajax()',2000);
}
}

xmlHttp5.onreadystatechange=function(){
if(xmlHttp5.readyState==4){
document.getElementById('Chart_6').innerHTML=xmlHttp5.responseText;
setTimeout('Ajax()',5000);
}
}
xmlHttp.open("GET","myChart.php",true);
xmlHttp1.open("GET","myChart_1.php",true);
xmlHttp2.open("GET","myChart.php",true);
xmlHttp3.open("GET","myChart.php",true);
xmlHttp4.open("GET","myChart.php",true);
xmlHttp5.open("GET","myChart.php",true);
xmlHttp.send(null);
xmlHttp1.send(null);
xmlHttp2.send(null);
xmlHttp3.send(null);
xmlHttp4.send(null);
xmlHttp5.send(null);
}

window.onload=function(){
setTimeout('Ajax()',5000);
}


</script>
<body bgcolor="BLACK">
<div id="container" style="overflow:auto">
		<div id="header">
        	<h1>SM-3<span class="off">Provenance</span></h1>
            <h2>CSC-591 : Cloud Computing</h2>
        </div>   
        
        <div id="menu">
        	<ul>
            	<li class="menuitem"><a href="#">Home</a></li>
                <li class="menuitem"><a href="#">About</a></li>
                <li class="menuitem"><a href="#">Resource Allocation</a></li>
                <li class="menuitem"><a href="#">Operational Profile</a></li>
                <li class="menuitem"><a href="#">Failure Statistics</a></li>
              <li class="menuitem"><a href="#">Security</a></li>
            </ul>
        </div>
        
        <div id="leftmenu">

        <div id="leftmenu_top"></div>

				<div id="leftmenu_main">    
                
                <h3>Links</h3>
                        
                <ul>
                    <li><a href="#">Image Profiles</a></li>
                    <li><a href="#">Management</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Group Allocation</a></li>
                    <li><a href="#">Graphs</a></li>
                    <li><a href="#">Provenance</a></li>
                    <li><a href="#">How it Works</a></li>
                    <li><a href="#">Contact US</a></li>
                    <li><a href="#">SM-3 Team</a></li>
                </ul>
</div>
                
                
              <div id="leftmenu_bottom"></div>
        </div>
        
        
        
        
		<div id="content">
        
        
        <div id="content_top"></div>
        <div id="content_main">
		<div id="Chart_1" style="align:center" >
		
		</div> <br>
				<div id="Chart_2" style="align:center" >
		<p>Hello</p>
		</div>
				<div id="Chart_3" style="align:center" >
		<p>Hello</p>
		</div>
				<div id="Chart_4" style="align:center" >
		<p>Hello</p>
		</div>
				<div id="Chart_5" style="align:center" >
		<p>Hello</p>
		</div>
				<div id="Chart_6" style="align:center" >
		<p>Hello</p>
		</div>
			</div>
        <div id="content_bottom"></div>
            
            <div id="footer"><h3><a href="http://www.bryantsmith.com"></a></h3></div>
      </div>
   </div> //
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
