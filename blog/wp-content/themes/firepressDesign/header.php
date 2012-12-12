<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
	<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'firepressDesign' ), max( $paged, $page ) );

	?></title>
		<?php wp_head(); ?>
        
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
        <script type="text/javascript">
			$(function(){
				$('.postNav').insertBefore('.fbcomments');	
				$('#postCats').insertBefore('.PostNav');
				$('.wp-post-image').css('max-width', '100%');
				$('#forJQTitleMod').css({ "font-weight" : "bolder"  });
				var pageTitleHeight;
				var taglinePadding;
				var titleLength;
				titleLength = $('#forJQTitleMod').width();
				pageTitleHeight = $('#pageTitle').height();
				taglinePadding = Math.floor(pageTitleHeight / 2);
				$('#pageTitle').css({"width" : titleLength + 15, "font-weight" : "bolder"  });
				$('#titleTagWCat').css({ "top": taglinePadding });
				$('#titleTagline').css ({ "top" : taglinePadding });
				$('.shareThoughts').insertAfter('.fbcomments h3');
				//$('.shareThoughts').
			});
		</script>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			
			
			
			
        </script>

    	<div id="header">
      		<h1>HEADER</h1>
    	</div>
  		<div id="wrapper">
            <div id="topAd">
                <img src="http://localhost/wp-content/themes/firepressDesign/images/topAd.jpg" alt="Top Ad Position">
            </div>
			<div id="main">	
  				<div id="content">