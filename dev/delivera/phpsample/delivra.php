<?php

require_once('lib-nusoap/nusoap.php');

$boolTest = true;

$url = 			"http://integration.delivra.com/DelivraServices/MemberService.asmx?WSDL";
$namespace = 	"http://delivra.com/";

$username = 	"api.delivra@delivra.com";
$password = 	"apipass";
$list = 		"api-delivra";

if ($boolTest) {
	$emailAddress = "pat@delivra.com";
	$firstName = 	"Pat";
	$lastName = 	"Jones";
	$fullName = 	"Pat Jones";
	$number1 = 		199;
	$address = 		"123 Delivra Ave.";
	$addressCity = 	"Indianapolis";
	$addressState = "IN";
	$addressZip = 	"12345";
	$addressPhone = "888-555-1212";
}
//Read template soap body from an xml file
$Message = file_get_contents("message.xml");

//Build the simple header
$parameters = array(
	"Username" => 		$username,
	"Password" => 		$password,
	"List" => 			$list
	);
	

$client = new nuSoapClient($url,true);
$client->setHeaders($parameters);
$result = $client->call('Add', $Message,$namespace );

echo "<html lang=\"en\"><head><title>PHP/NUSOAP: $namespace</title></head><body>";

if ($client->fault) {
	echo "<h1 style=\"color:#800;\">Error</h1>";
	echo "<pre style=\"color:#800;\">"; 
	print_r($result); 
	echo "</pre><hr />";
} else {
	$err = $client->getError();
	if ($err) {
		echo "<h1 style=\"color:#800;\">Error</h1>";
		echo "<pre style=\"color:#800;\">$err</pre><hr />";
	} else {
		echo "<h1 style=\"color:#060;\">Success!</h1>";
		echo "<pre style=\"color:#060;\">"; 
		print_r($result); 
		echo "</pre><hr />";
	}
}

if ($boolTest) {
	echo "<h1>Request</h1><pre>".htmlspecialchars($client->request,ENT_QUOTES)."</pre><hr />";
	echo "<h1>Response</h1><pre>".htmlspecialchars($client->response,ENT_QUOTES)."</pre><hr />";
	echo "<h1>Debug</h1><pre>".htmlspecialchars($client->debug_str,ENT_QUOTES)."</pre><hr />";
}

echo "<p style=\"font-size:.8em;\">done.</p>";
echo "</body></html>";

?>