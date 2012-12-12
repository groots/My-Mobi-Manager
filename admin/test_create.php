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


$cCard = "601000998380707";




$date = date("Y-m-d");
//define variables to send
$amount = .01;
$refId = "023423000";
$name = "groots@squishdesigns";
$length = 1;
$unit = "months";
$startDate = $date;
$totalOccurrences = 1;
$trialOccurrences = 0;
$trialAmount = 0.00;
$cardNumber = $cCard;
$expirationDate="12-08";
$firstName = "I";
$lastName = "payment";


echo 
$amount . "<br />" . 
$refId . "<br />" . 
$name  . "<br />" . 
$length  . "<br />" . 
$unit  . "<br />" . 
$startDate  . "<br />" . 
$totalOccurrences  . "<br />" . 
$trialOccurrences  . "<br />" . 
$trialAmount  . "<br />" . 
$cardNumber  . "<br />" . 
$expirationDate  . "<br />" . 
$firstName  . "<br />" . 
$lastName;

echo "Results <br><br>";

//build xml to post
$content =
        "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
        "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
        "<merchantAuthentication>".
        "<name>" . $loginname . "</name>".
        "<transactionKey>" . $transactionkey . "</transactionKey>".
        "</merchantAuthentication>".
		"<refId>" . $refId . "</refId>".
        "<subscription>".
        "<name>" . $name . "</name>".
        "<paymentSchedule>".
        "<interval>".
        "<length>". $length ."</length>".
        "<unit>". $unit ."</unit>".
        "</interval>".
        "<startDate>" . $startDate . "</startDate>".
        "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
        "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
        "</paymentSchedule>".
        "<amount>". $amount ."</amount>".
        "<trialAmount>" . $trialAmount . "</trialAmount>".
        "<payment>".
        "<creditCard>".
        "<cardNumber>" . $cardNumber . "</cardNumber>".
        "<expirationDate>" . $expirationDate . "</expirationDate>".
        "</creditCard>".
        "</payment>".
        "<billTo>".
        "<firstName>". $firstName . "</firstName>".
        "<lastName>" . $lastName . "</lastName>".
        "</billTo>".
        "</subscription>".
        "</ARBCreateSubscriptionRequest>";


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
	list ($refId, $resultCode, $code, $text, $subscriptionId) =parse_return($response);

	/*
	echo " Response Code: $resultCode <br>";
	echo " Response Reason Code: $code<br>";
	echo " Response Text: $text<br>";
	echo " Reference Id: $refId<br>";
	echo " Subscription Id: $subscriptionId <br><br>";
	echo " Data has been written to data.log<br><br>";
	echo $loginname;
	echo "<br />";
	echo $transactionkey;
	echo "<br />";
  
  echo "amount:";
  echo $amount;
  echo "<br \>";
  
  echo "refId:";
  echo $refId;
  echo "<br \>";
  
  echo "name:";
  echo $name;
  echo "<br \>";
  
  echo "amount: ";
  echo $HTTP_POST_VARS[amount];
  echo "<br \>";
  echo "<br \>";
  echo $content;
  echo "<br \>";
  echo "<br \>";
	*/
	
	
	$responseText =  $text;
	$responseTransKey = $transactionkey;
	$responseResultCode = $resultCode;
	$responseReasonCode = $code;
	
$fp = fopen('data.log', "a");
fwrite($fp, "$refId\r\n");
fwrite($fp, "$subscriptionId\r\n");
fwrite($fp, "$amount\r\n");
fclose($fp);

	
}
else
{
	echo "Transaction Failed. <br>";
}
?>

