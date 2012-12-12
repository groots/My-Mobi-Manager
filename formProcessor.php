<?PHP

	include("dbcon.php");
	$projectName="mobilemanager_";
	$userName = $_SESSION['u'];
	$emailInfo=mysql_fetch_array(mysql_query("select SiteName, logo, logoWidth, logoHeight, ocEmail, ocPhone, mainWebsite, homepageText, footer from ".$projectName."moSiteInfo where SiteName='$userName'"));
	
	

//Process all post data 



//format email
$to = $emailInfo['ocEmail'];

$subject = 'Email From Your Mobile Website';

$headers = "From: info@mymobimanager.com \r\n";
$headers .= "Reply-To: No Not Reply\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
foreach ($_POST as $key => $value){
	$message .= "<tr style='background: #eee;'><td><strong>$key:</strong> </td><td>" . strip_tags($value) . "</td></tr>";
	//echo $key . " - " . $value . "<br />";	
}

$message .= "</table>";
$message .= "</body></html>";
//Process email
//mail($to, $subject, $message, $headers);
if(mail($to, $subject, $message, $headers)){
	$returnMessage = "Email was sent"; 
} else {
	$returnMessage = "The Email was not sent";	
}

//Configure0 Message



//Return to Mobile Webile
$previousPage = $_SERVER['HTTP_REFERER'];

header("location: ". $previousPage . "&rm=" . $returnMessage);

?>