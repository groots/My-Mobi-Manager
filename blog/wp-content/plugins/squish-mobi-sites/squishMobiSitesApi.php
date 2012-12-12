<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="wrap"> <?php echo "<h2>" . __( 'Squish Mobi Sites Manager Display Options', 'sms_trdom' ) . "</h2>"; ?> 
	<form name="sms_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"> <input type="hidden" name="oscimp_hidden" value="Y"> <?php echo "<h4>" . __( 'Squish Mobi Sites Database Settings', 'oscimp_trdom' ) . "</h4>"; ?> 
    <p><?php _e("Username: " ); ?><input type="text" name="oscimp_store_url" value="<?php echo $store_url; ?>" size="20"><?php _e(" ex: http://www.username.mymobimanager.com/" ); ?></p> 
    <p><?php _e("API Key: " ); ?><input type="text" name="oscimp_prod_img_folder" value="<?php echo $prod_img_folder; ?>" size="20"><?php _e(" ex: http://www.yourstore.com/images/" ); ?></p> 
    <p class="submit"> <input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" /> </p> 
    </form> </div>  



<?PHP
require("RestRequest.inc.php");
$inputs = array();
$inputs["username"] = "squishdesigns";
$inputs["apiKey"] = "902cd00e1fc3810a4ba5a9de9be1c4ba";
$inputs["motive"] = "Viewpages";
$inputs["pageId"] = "";
$inputs["designElements"] = "";
$request = new RestRequest('http://mymobimanager.com/apiroom/displayMobilePages.php', 'POST',$inputs);
$request->setUsername("squishdesigns");
$request->setPassword("letmein");

$request->execute();

echo '<pre>' . print_r($request, true) . '</pre>';
?>
</body>
</html>
