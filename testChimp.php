<?php
$apikey = 'cfd4263fd6fb922950c74d2e778ce56b-us1';
$listID = '128385';


$_POST['subscribe'] = 1;
$_POST['email'] = "squisher@squishdesigns.com";
$_POST['message'] = "Hope this works";
$_POST['newsletter'] = 1;
if (isset($_POST['subscribe'])) {
	if (preg_match("(\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,})", $_POST['email'])) {
		$email = $_POST['email'];
		//
		// process here the contact form data like name and message
		mail('squish@squishdesigns.com', 'Subject: contact form', $_POST['message']); // example
		//
		if (!empty($_POST['newsletter'])) {
			$url = sprintf('http://api.mailchimp.com/1.2/?method=listSubscribe&apikey=%s&id=%s&email_address=%s&merge_vars[OPTINIP]=%s&merge_vars[MMERGE1]=webdev_tutorials&output=json', $apikey, $listID, $email, $_SERVER['REMOTE_ADDR']);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch);
			curl_close($ch);
			$arr = json_decode($data, true);
			if ($arr == 1) {
				echo 'Check now your e-mail and confirm your subsciption.';
			} else {
				switch ($arr['code']) {
					case 214:
					echo 'You are already subscribed.';
					break;
					// check the MailChimp API for more options
					default:
					echo 'Unkown error...';
					break;			
				}
			}
		}
	}
}
?>