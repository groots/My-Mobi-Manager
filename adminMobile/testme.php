<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" href="http://www.coldfusionjedi.com/demos/jquerytabs/theme/ui.all.css" />
<script src="http://www.coldfusionjedi.com/demos/jquerytabs/jquery-1.3.1.js"></script>
<script src="http://www.coldfusionjedi.com/demos/jquerytabs/jquery-ui-personalized-1.6rc6.js"></script>
<script>
$(document).ready(function() {
	$("#example").tabs();					   
});
</script>
</head>

<body>

<div id="example">
     <ul>
         <li><a href="#first-tab"><span>Content 1</span></a></li>
         <li><a href="#second-tab"><span>Content 2</span></a></li>
         <li><a href="#third-tab"><span>Content 3</span></a></li>
     </ul>
	 
	 <div id="first-tab">
	 This is the first tab.
	 </div>

	 <div id="second-tab">
	 This is the second tab.
	 </div>

	 <div id="third-tab">
	 This is the third tab.
	 </div>

</div>

</body>
</html>
