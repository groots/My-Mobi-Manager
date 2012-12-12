
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
defined( '_JEXEC' ) or die( 'Restricted index access' ); ?>
<jdoc:include type="head" />
<style type="text/css">
.yjsquare
h4,.button, .validate, a.pagenav, .pagenav_prev a, .pagenav_next a,
.pagenavbar a, .back_button a, #footer, a.readon:link, a.readon:visited
{background:<?php echo $hi_color?>;}
</style>
<?php JHTML::_('behavior.mootools'); echo $add_jq .$add_jq_noc?>

<? 
	$isMobile = isset($_GET['mobileWeb']) ? $_GET['mobileWeb'] : "";
	$_SESSION['squishMobile'] = $isMobile;
	
	
	if ($_SESSION['squishMobile'] == 'yes' OR $_SESSION['squishMobile'] == ""  ) {
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/android|avantgo|blackberry|blazer|samsung|compal|elaine|fennec|hiptop|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile|o2|opera m(ob|in)i|palm( os)?|p(ixi|re)\/|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		header('Location: http://m3.mymobimanager.com');
	} elseif ($_SESSION['squishMobile'] == 'no') {
		?>
        <!--a href="http://squishdesigns.mymobimanager.com" style="position: absolute; bottom: 0px; height: 30px; background: white; color: black; border: thin solid #000; width: 100%; left: 30px;">Go Back to Mobile site</a-->
        <?
	}	
	?>
<?php if ($compress == 0){ ?>
		<link href="<?php echo $yj_site ?>/css/template.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $yj_site ?>/css/<?php echo $css_file; ?>.css" rel="stylesheet" type="text/css" />
<?php }elseif ($compress == 1){ ?>
		<link href="<?php echo $yj_site ?>/css/compress.php" rel="stylesheet" type="text/css" />
<?php  } ?>
<?php if ($yjsg_mobile){?>
		<link href="<?php echo $yj_site ?>/css/mobile/iphone.css" rel="stylesheet" type="text/css" />
<?php }?>
<?php if (in_array('YJsground', $mod_round_style)){ ?>
		<link href="<?php echo $yj_site ?>/css/rounded.css" rel="stylesheet" type="text/css" />
<?php } ?>

<?php if ( $default_menu_style == 3 ||  $default_menu_style == 4 ){ ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/dropline<?php echo $dropline ?>.css" type="text/css" />
<?php  } ?>

<?php if ($text_direction == 1) { ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/template_rtl.css" type="text/css" />
		<?php if (preg_match("/chrome/",$who) || preg_match("/safari/",$who)) { ?><?php }else{ ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/menu_rtl.css" type="text/css" />
		<?php  } ?>
<?php  } ?>
<?php require_once( YJ_TEMPLATEPATH.DS."yjsgcore/yjsg_hconditions.php"); ?>
<?php if($default_menu_style !=='5'){require_once( YJ_TEMPLATEPATH.DS."yjsgcore/yjsg_menuoffsets.php");} ?>
<?php if ($text_direction == 1 && $isie6 == true && ($default_menu_style == 3 ||  $default_menu_style == 4)) { ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/droplineie6-rtl.css" type="text/css" />
<?php  } ?>
<?php if ($text_direction == 1 && preg_match("/msie 7/",$who) && ($default_menu_style == 3 ||  $default_menu_style == 4)) { ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/droplineie7-rtl.css" type="text/css" />
<?php  } ?>
<?php if ($custom_css   == 1) { ?>
		<link rel="stylesheet" href="<?php echo $yj_site ?>/css/custom.css" type="text/css" />
<?php  } ?>