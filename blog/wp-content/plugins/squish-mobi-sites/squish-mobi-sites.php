<?php 
/* Plugin Name: Squish Mobi Sites Manager Plugin 
URI: http://www.mymobimanager.com 
Description: Plugin for Squish Mobi Site customers to manage their mobile websites
Author: George Roots 
Version: 1.0 
Author URI: http://www.squishdesigns.com */ 

function amMobi ($text) {
	$text = str_replace('Mobile', 'Mobi', $text);	
	return $text;
}

//add_filter('the_content', 'amMobi'); 
//add_filter('the_title', 'amMobi'); 


function sms_admin() {
	include("squishMobiSitesApi.php");		
}

function sms_admin_actions () {
	add_options_page("Squish Mobi Sites Manager", "Squish Mobi Sites Manager", "administrator", __FILE__, "sms_admin");
}
add_action('admin_menu', 'sms_admin_actions');



?>