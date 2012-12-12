<?php

include("session_check.php");
$Userid=$_SESSION['ID'];




				$query  = "SELECT * FROM mobilemanager_page WHERE Userid = $Userid ORDER BY Pageorder ASC";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
					['<?php echo $row['Pagetitle']; ?>', '<?php echo $row['Seourl'];?>']
				
		  <?php } ?>
                

