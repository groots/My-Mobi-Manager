<?php

/****NOTE***
Please download the PHP SDK available at https://developer.authorize.net/downloads/ for more current code.
*/

/*
D I S C L A I M E R                                                                                          
WARNING: ANY USE BY YOU OF THE SAMPLE CODE PROVIDED IS AT YOUR OWN RISK.                                                                                   
Authorize.Net provides this code "as is" without warranty of any kind, either express or implied, including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.   
Authorize.Net owns and retains all right, title and interest in and to the Automated Recurring Billing intellectual property.
*/

$loginname="6c37jfNTF5N";
$transactionkey="6N33Vtf64m7FZcb3";
$host = "api.authorize.net";
$path = "/xml/v1/request.api";
include ("includes/authnetfunction.php");

//define variables to send
/*
$subscriptionId = $_POST["subscriptionId"];
$cardNumber = $_POST["cardNumber"];
$expirationDate = $_POST["expirationDate"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
*/

$subscriptionId = $_POST['subId'];
$cardNumber = $_POST['cardNumber'];

$year = $_POST['card_expires_year'];
$month = $_POST['card_expires_month'];
$expirationDate = $year . "-" . $month;

$firstName = $_POST['fName'];
$lastName = $_POST['lName'];
$amount = $amount;

//build xml to post
$content =
        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
        "<ARBUpdateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
        "<merchantAuthentication>".
        "<name>" . $loginname . "</name>".
        "<transactionKey>" . $transactionkey . "</transactionKey>".
        "</merchantAuthentication>".
        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
        "<subscription>".
        "<amount>". $amount ."</amount>".
        "<payment>".
        "<creditCard>".
        "<cardNumber>" . $cardNumber ."</cardNumber>".
        "<expirationDate>" . $expirationDate . "</expirationDate>".
        "</creditCard>".
        "</payment>".
        "</subscription>".
        "</ARBUpdateSubscriptionRequest>";

//send the xml via curl
$response = send_request_via_curl($host,$path,$content);
//if curl is unavilable you can try using fsockopen
/*
$response = send_request_via_fsockopen($host,$path,$content);
*/

//if the connection and send worked $response holds the return from Authorize.net
if ($response)
{
		/*
	a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
	please explore using SimpleXML in php 5 or xml parsing functions using the expat library
	in php 4
	parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
	*/
	list ($resultCode, $code, $text, $subscriptionId) =parse_return($response);

	
	
$fp = fopen('data.log', "a");
fwrite($fp, "$subscriptionId\r\n");
fwrite($fp, "$text\r\n");
fclose($fp);

	
}
else
{
	echo "Transaction Failed. <br>";
}
?>