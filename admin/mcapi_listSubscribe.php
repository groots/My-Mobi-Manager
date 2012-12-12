<?php
/**
This Example shows how to Subscribe a New Member to a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'inc/MCAPI.class.php';
//require_once 'inc/config.inc.php'; //contains apikey
/////////////////////////////////////////////////////////////////////////////////////////////////////////
    //API Key - see http://admin.mailchimp.com/account/api
	$uapi = "";
    $apikey = 'cfd4263fd6fb922950c74d2e778ce56b-us1';
    
    // A List Id to run examples against. use lists() to view all
    // Also, login to MC account, go to List, then List Tools, and look for the List ID entry
	$ulistId = "";
    $listId = 'YOUR MAILCHIMP LIST ID - see lists() method';
    
    // A Campaign Id to run examples against. use campaigns() to view all
    $campaignId = 'YOUR MAILCHIMP CAMPAIGN ID - see campaigns() method';

    //some email addresses used in the examples:
    $my_email = 'INVALID@example.com';
    $boss_man_email = 'INVALID@example.com';

    //just used in xml-rpc examples
    $apiUrl = 'http://api.mailchimp.com/1.3/';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	

$api = new MCAPI($apikey);

$merge_vars = array('FNAME'=>'Test', 'LNAME'=>'Account', 
                  'GROUPINGS'=>array(
                        array('name'=>'Your Interests:', 'groups'=>'Bananas,Apples'),
                        array('id'=>22, 'groups'=>'Trains'),
                        )
                    );

// By default this sends a confirmation email - you will not see new members
// until the link contained in it is clicked!
$retval = $api->listSubscribe( $listId, $my_email, $merge_vars );

if ($api->errorCode){
	echo "Unable to load listSubscribe()!\n";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {
    echo "Subscribed - look for the confirmation email!\n";
}

?>
