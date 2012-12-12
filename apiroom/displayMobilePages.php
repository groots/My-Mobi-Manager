<?PHP
//varible declaration
	$username = isset($_POST['username']) ? $_POST['username'] : $_GET['username'];
	//$username = $_POST['username'];
	//$apiKey = $_POST['apiKey'];
	$apiKey = isset($_POST['apiKey']) ? $_POST['apiKey'] : $_GET['apiKey'];
	//$format = $_POST['apiFormat'];
	//$format="json";	

if(isset($_POST['username']) || isset($_GET['username'])) {
	if(isset($_POST['username'])) 
		$uName = $_POST['username'];
	 else 
		$uName = $_GET['username'];
	
					
	
	if(isset($_POST['apiKey']) || isset($_GET['apiKey'])){
	
		$link2 = mysql_connect('localhost','squish7_expert','XmjujdK*I;6%') or die('Cannot connect to the DB');
		mysql_select_db('squish7_miMoby',$link2) or die('Cannot select the DB');
		
		$userInfo=mysql_fetch_array(mysql_query("SELECT * FROM mobilemanager_user WHERE Username = '$uName'"));
		/*
		$query = "SELECT * FROM mobilemanager_user WHERE Username = '$uName'";
		$result = mysql_query($query) or die('Errant query:  '.$query);
		if(mysql_num_rows($result)) {
			while($post = mysql_fetch_assoc($result)) {
				
			}
		}
		*/
		if ($apiKey == $userInfo['apiKey']) {
			//echo "Welcome " . $userInfo['Username'] . ", You are now ready to integrate";
			
			$getPages = "SELECT Pagetitle, content, Seourl, Rsspath, fStackFormId, ccFlag, Parentlink, lastestTweet FROM mobilemanager_page WHERE Userid = " . $userInfo['Userid'];
			$result = mysql_query($getPages) or die('Errant query:  '.$getPages);			
			$mages = array();			
			if(mysql_num_rows($result)) {
				while($mage = mysql_fetch_assoc($result)) {
					$mages[] = array('mage'=>$mage);
				}
			}

			/*if(mysql_num_rows($result)) {
				while($row = mysql_fetch_assoc($result)) {
					echo $row['Pagetitle'] . "<br />";
				}
			}
			*/
			
			/* output in necessary format */
			if($format == 'json') {
				header('Content-type: application/json');
				echo json_encode(array('mages'=>$mages));
			}
			else {
				header('Content-type: text/xml');
				echo '<mages>';
				foreach($mages as $index => $mage) {
					if(is_array($mage)) {
						foreach($mage as $key => $value) {
							echo '<',$key,'>';
							if(is_array($value)) {
								foreach($value as $tag => $val) {
									echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
								}
							}
							echo '</',$key,'>';
						}
					}
				}
				echo '</mages>';
			}

		} else {
			echo "Your API Key is incorrect";
		}
		
		/* disconnect from the db */
		@mysql_close($link2);
	}
}
?>