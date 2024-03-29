<?php

global $mainframe;

// Not through Joomla entrance
if ( !defined( '_JEXEC' ) ) {
	global $option;

	define( '_JEXEC', 1 );
	define( '_WP_INCLUDED_J', 1 );
	if ( !defined( 'DS' ) ) {
		define( 'DS', DIRECTORY_SEPARATOR );
	}

	// If WP Single or multi-site?
	if ( file_exists( dirname(__FILE__) .DS. '..' .DS. 'configuration.php' ) ) {
		define( 'JPATH_BASE', realpath( dirname(__FILE__) . DS.'..' ) ); // Multi-site
	} else {
		define( 'JPATH_BASE', realpath( dirname(__FILE__) . DS.'..'.DS.'..'.DS.'..' ) ); // Single
	}

	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	$mainframe	=& JFactory::getApplication( 'site' );
	$mainframe->initialise();
} else {
	if ( !$mainframe ) {
		$mainframe = JFactory::getApplication( 'site' );
	}
}

if ( !function_exists( 'myPrint' ) ) :
/**
 * Function for printing data
 * @return 
 */
function myPrint( $var, $pre = true )
{
	if ( $pre ) {
		echo '<pre>';
	}
	print_r($var);
	if ( $pre ) {
		echo '</pre>';
	}
}
endif;

/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @internal This file must be parsable by PHP4.
 *
 * @package WordPress
 */

/** Define ABSPATH as this files directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'wp-config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'wp-config.php' );

}
/* rc_corephp No need for these additional checks as we are using Joomla */
// elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) && ! file_exists( dirname(ABSPATH) . '/wp-settings.php' ) ) {
// 
// 	/** The config file resides one level above ABSPATH but is not part of another install*/
// 	require_once( dirname(ABSPATH) . '/wp-config.php' );
// 
// } else {
// 
// 	// A config file doesn't exist
// 
// 	// Set a path for the link to the installer
// 	if (strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false) $path = '';
// 	else $path = 'wp-admin/';
// 
// 	// Die with an error message
// 	require_once( ABSPATH . '/wp-includes/classes.php' );
// 	require_once( ABSPATH . '/wp-includes/functions.php' );
// 	require_once( ABSPATH . '/wp-includes/plugin.php' );
// 	$text_direction = /*WP_I18N_TEXT_DIRECTION*/"ltr"/*/WP_I18N_TEXT_DIRECTION*/;
// 	wp_die(sprintf(/*WP_I18N_NO_CONFIG*/"There doesn't seem to be a <code>wp-config.php</code> file. I need this before we can get started. Need more help? <a href='http://codex.wordpress.org/Editing_wp-config.php'>We got it</a>. You can create a <code>wp-config.php</code> file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file.</p><p><a href='%ssetup-config.php' class='button'>Create a Configuration File</a>"/*/WP_I18N_NO_CONFIG*/, $path), /*WP_I18N_ERROR_TITLE*/"WordPress &rsaquo; Error"/*/WP_I18N_ERROR_TITLE*/, array('text_direction' => $text_direction));
// 
// }

?>