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
mail chimp 
<br />

<?php
/**
This Example shows how to pull the Members of a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'inc/MCAPI.class.php';
require_once 'inc/config.inc.php'; //contains apikey


    $apikey = 'cfd4263fd6fb922950c74d2e778ce56b-us1';

$api = new MCAPI($apikey);

$retval = $api->lists();

if ($api->errorCode){
	echo "Unable to load lists()!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
} else {
	echo "Lists that matched:".$retval['total']."\n";
	echo "Lists returned:".sizeof($retval['data'])."\n";
	foreach ($retval['data'] as $list){
		//echo "Id = ".$list['id']." - ".$list['name']."\n";
		echo "Web_id = ".$list['web_id']."\n";
		//echo "\tSub = ".$list['stats']['member_count'];
		//echo "\tUnsub=".$list['stats']['unsubscribe_count'];
		//echo "\tCleaned=".$list['stats']['cleaned_count']."\n";
	}
}

?>

</body>
</html>
