<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title> <?php if ( !is_single() ) { bloginfo('name'); }else{ wp_title(''); ?> | <?php bloginfo('name'); } ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>



<body>



<div id="wrapper">

	<div class="header" id="header">

		<div class="blogname">
			<div class="tagline"><?php bloginfo('description'); ?></div>
			<h1 style="margin: 0;"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		</div>

		<div class="clear"></div>
		
	</div>

	

	<div class="pageo">
	
	<div class="pagei">