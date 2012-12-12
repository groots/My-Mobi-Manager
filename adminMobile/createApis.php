<?PHP

include("session_check.php");
$Userid=$_SESSION['ID'];
$mixer = "mobiHider1";

//Select Rows in Database
				$query  = "SELECT Userid, Username FROM mobilemanager_user WHERE apiKey =''";
				$result = mysql_query($query);
				$s =0;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					$s++;
					$apiRoot = $mixer . $row['Username'];
					$newApiRoot = md5($apiRoot);
					$sql = "UPDATE mobilemanager_user SET apiKey = '$newApiRoot' WHERE Userid =" . $row['Userid'];
					echo $sql . "<br />";
					mysql_query($sql);
			?>
            
			<? }



?>