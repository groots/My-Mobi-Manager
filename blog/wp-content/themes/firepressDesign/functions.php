<?php
	
	/*
	******************************************************************************************************************************************************************************
	    ****************************************************               Adding Actions to WP                 *************************************************************
	******************************************************************************************************************************************************************************
	*/
	add_action('admin_menu', 'add_global_custom_options');
	add_action('admin_init', 'firepress_options_init');
	add_theme_support( 'post-thumbnails' ); 
	if ( function_exists('register_sidebar') )
    register_sidebar();
	
	/**
	 *	This script displays latest four blog posts sorted by category 
	 *	
	 *	Accepted Args: 
	 *	$numOfPosts as the number of posts that can appear under a category
	 *
	 */
	function firepressDesign_setup()
	{
		if(is_admin()){
			require_once('lib/firedpress-theme-settings-basic.php');	
		}
	}
	
	/**
	 *	This script displays latest four blog posts sorted by category 
	 *	
	 *	Accepted Args: 
	 *	$numOfPosts as the number of posts that can appear under a category
	 *
	 */
	function firepress_options_init () {
		register_setting( 'options', 'firepress_options');	
	}
	
	
	/**
	 *	This script displays latest four blog posts sorted by category 
	 *	
	 *	Accepted Args: 
	 *	$numOfPosts as the number of posts that can appear under a category
	 *
	 */
	function add_global_custom_options()
	{
		add_options_page('Global Custom Options', 'Global Custom Options', 'manage_options', 'functions', 'global_custom_options');	
		
	}


	/**
	 *	This script displays latest four blog posts sorted by category 
	 *	
	 *	Accepted Args: 
	 *	$numOfPosts as the number of posts that can appear under a category
	 *
	 */
	function global_custom_options()
	{
	?>
    	<div class="wrap">
        	<h2>Global Custom Options</h2>
            <form method="post" action="options.php">
            	<?php wp_nonce_field('update-options'); ?>
                <p><strong>Twitter ID: </strong><br />
                	<input type="text" name="twitterid" size="45" value="<?php echo get_option('twitterid'); ?>" />
                </p>
                <p><strong>Facebook App ID: </strong><br />
                	<input type="text" name="fbAppID" size="45" value="<?php echo get_option('fbAppID'); ?>" />
                <p><input type="submit" name="Submit" value="Store Options" /></p>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="twitterId,fbAppID" />
            </form>
        </div>
        
    <?php
	}
	
	/*
	******************************************************************************************************************************************************************************
	    ****************************************************               Start of Content Functions                 ********************************************************
	******************************************************************************************************************************************************************************
	*/
	
	
	
	/**
	 *	Displays Page Title Info and tagline.  This will be made to be set in the theme options in the wordpress admin area  
	 *
	 *	Currently displays 48px Blog title with tagline to the right of blog title
	 *
	 *	Accepted Args: 
	 * $blogTitle = The title of the blog
	 * $titleTagline = The tagline associated with this blog.
	 */
	 
	function callPageTitleInfo($pTitle, $tagline, $catSocialBookmarks){
	?>
    	<div id="pageTitleWrapper">
            <div id="pageTitle">
            	<span id="forJQTitleMod"><?php do_action('taxonomy_image_plugin_print_image_html', 'medium'); echo $pTitle; ?></span> 
            </div>
                
                <?php
						
					if (is_category() || is_single()){
						$catFB = $catSocialBookmarks['twHandle'];
						$catTwitter = $catSocialBookmarks['fbHandle'];
						$catRSS = $catSocialBookmarks['rssFeed'];
						$catTwitter != "" ? ($buildCatSocBMK .= "<img src='" . get_bloginfo('template_directory') . "/images/twitterIcon.png' /> ") : "";
						$catFB != "" ? ($buildCatSocBMK .= "<img src='" . get_bloginfo('template_directory') . "/images/fbIcon.png' /> ") : "";
						$catRSS != "" ? ($buildCatSocBMK .= "<img src='" . get_bloginfo('template_directory') . "/images/RSSIcon.png' /> ") : "";
						$taglineDivId = ($buildCatSocBMK == "" ? "titleTagline" : "titleTagWCat" );
					} else {
						$taglineDivId = "titleTagline";	
					}
						
				?>
                <div id="<?php echo $taglineDivId; ?>">
                	<?php
						$removePTags = array("<p>", "</p>");
						if ($tagline != "") {
							$tagline = str_replace($removePTags, "", $tagline); 
						} else {
							$tagline = get_bloginfo('description' );	
						}
						echo $tagline . "<span id='catSocialBookmarks' >$buildCatSocBMK</span>"; 
					?>
                            
                </div>
    	</div>
        <div class="clear"></div>
    <?php		
	}
	
	
	function callBookmarks($category)
	{
		?><div id="breadCrumbs"><?php
		
		
		$args = array('parent' => 0); 
		$gotCategories = get_categories($args);
		$totCats = count($gotCategories);
		$p = 1;
		foreach($gotCategories as $topCat) :
			$allTopCats .= "<a class='bookmarkItem' href='" . get_category_link($topCat->term_id)  . "'>$topCat->name</a>";	
			//add pipe between top categories
			if(($p+1) != $totCats) { 
				$allTopCats .= " | ";
			}
			$p++;
			if ($p == $totCats) break;
		endforeach;
	
		if(is_home()){
		?>
                <div id="bc_jumpto_text">Jump to: </div><div id="bc_list_cats"><?php echo $allTopCats; ?></div>
        <?php
		} else {
			if ($category != ""){
				$args = array('orderby' => 'name', 
							  'category_name' => $category, 
							  'categorize' => 0,
							  'title_li' => "",  
							  'title_before' => "",
							  'title_after' => "");
				$args2 = array('orderby' => 'name', 'category_name' => $category);
				$bookmarks = get_bookmarks($args2);
				if(!empty($bookmarks)) {			
		?>
                	<div id="bc_jumpto_text">QUICK LINKS: </div><div id="bc_list_cats"><?php wp_list_bookmarks($args); ?></div>
		<? 	
				} else {
		?>
                	<div id="bc_jumpto_text">Jump to: </div><div id="bc_list_cats"><?php echo $allTopCats; ?></div>
        <?php	
				}
			}
		}?></div><?php
	}
	
	function callSubCategory() {
		
	}
	
	function callSidebar()
	{
		?>
        <div id="sidebarWrapper">
            <?php get_sidebar(); ?>
        </div>
        <?php	
	}
	/**
	 *	Displays any active social bookmarks.  
	 *	Currently displaying Facebook Like, Twitter follow and Google Plus One
	 *
	 *	No Args.
	 *	Can see a future request to display specific bookmarks versus the original "show them all"
	 */
	
	function callSocialBookmarks($class){
		?>
        <div id="socialBookmarks" class="<?php echo $class; ?>">
            <div class="fb-like" data-href="http://www.squishdesigns.com" data-send="false" data-layout="button_count" data-width="75" data-show-faces="true"></div>
    
            
            <a href="https://twitter.com/georgeroots" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @georgeroots</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
    
            <span id="myGPlus"> <g:plusone href="<?php echo get_permalink(); ?>"></g:plusone></span>
        </div>
        <?php	
	}
	
	function callStylelessSocialBookmarks()
	{
		?>
        <span >
            <div class="fb-like" data-href="http://www.squishdesigns.com" data-send="false" data-layout="button_count" data-width="90" data-show-faces="true"></div>
    
            
            <a href="https://twitter.com/georgeroots" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @georgeroots</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
    
            <g:plusone href="<?php echo get_permalink(); ?>"></g:plusone>
        </span>
        <?php
	}
	
	
	function getSubCats() 
	{
		$allCategories = get_categories($args);
		$subCats = array();
		$i = 0;
		foreach($allCategories as $category) {
			if($category->parent != 0 ){
				$subCats[$i] = $category->name;
			}
			$i++;
		}
		return $subCats;
	}
	
	function category_has_children($category) {
		global $wpdb;	
		$term = $category;
		$category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
		if ($category_children_check) {
			echo "yes";
		} else {
			echo "no";
		}
	}
	
	function get_topLevelParent ($postid) {
	}
?>