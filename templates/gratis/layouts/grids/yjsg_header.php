<?php
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla LLC. All Rights Reserved.            ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla LLC                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/
defined( '_JEXEC' ) or die( 'Restricted index access' );
$css_width = $this->params->get("css_width");
$YJ_modules = array();
$YJ_max_modules = 3;
$YJ_module_prefix = 'header';
$YJ_starting_key = 1;
$grid_widths = explode('|', $this->params->get( 'yjsg_header_width' ));
require( YJ_TEMPLATEPATH.DS."yjsgcore/yjsg_widths.php");
if($turn_logo_off == 1) {
$headergrid_width = 100;
}else{
$headergrid_width = 100 -$logo_out;
}
?>
<?php if( $YJ_modules ):?>
<div id="yjsgheadergrid" style="width:<?php echo $headergrid_width; ?>%;">
	<?php foreach ($YJ_modules as $k=>$mod_width): 
		$mod_name = $YJ_module_prefix.$k; 
		if( !$mod_width ) continue;
	?>
	<div id="<?php echo $mod_name;?>" class="yjsgxhtml" style="width:<?php echo $mod_width;?>%;">
		<jdoc:include type="modules" name="<?php echo $mod_name;?>" style="<?php echo $YJsgh_module_style ?>" />
	</div>
	<?php endforeach;?>
</div>
<?php endif;?>