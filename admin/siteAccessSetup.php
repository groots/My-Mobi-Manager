<?PHP


	$con=mysql_connect("localhost","squish7_expert","XmjujdK*I;6%");
	 if (!$con){
		die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("squish7_miMoby", $con);
	$projectName="mobilemanager_";
	
	
	
	$sql = "SELECT * FROM mobilemanager_user WHERE 1";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$ui = $row['Userid'];
		
		$sql2 = "UPDATE mobilemanager_user SET siteAccess = $ui WHERE Userid = $ui";
		
	echo $sql2 . "<BR />";
		mysql_query($sql2);
		
	}
	
	?>
	