<SCRIPT language=JavaScript>
<!-- http://www.spacegun.co.uk -->
<?php
  echo " 	var message = \"$surp_sitename v.$surp_sitever\"; \n";
?>
	function rtclickcheck(keyp){ if (navigator.appName == "Netscape" && keyp.which == 3){ 	alert(message); return false; } 
	if (navigator.appVersion.indexOf("MSIE") != -1 && event.button == 2) { 	alert(message); 	return false; } } 
	document.onmousedown = rtclickcheck;
</SCRIPT>
