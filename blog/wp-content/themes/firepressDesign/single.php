<?php 
		get_header(); 
	
		$categories = get_the_category();
        $category= '';
		// trying to get top level category
        foreach($categories as $childcat) {
            $parentcat = $childcat->category_parent;
            if($parentcat>0){
                $category = get_cat_name($parentcat);
                continue;
             }
        }
		
        $category = (strlen($category)>0)? $category :  $categories[0]->cat_name;
		$catId = get_cat_ID($category);
		$tagline = category_description($catId);
		
		//Getting Category Socialbookmark information from mysql from headspace option field
		$wpsql ="select * from wp_" . $blog_id . "_options where option_name = 'headspace_cat_" . $catId . "'";
		$myrows = $wpdb->get_results( $wpsql); 
		$socialCatBlob = $myrows[0]->option_value;
		
		//filtering results to break up string into usable parts 
		$matches = array();
		$t = preg_match('/"Twitter Handle"(.+)"/', $socialCatBlob, $matches);
		$firstResult = $matches[0];
		$socialCatOnPost = preg_split('/(".*?")|\s+/', $firstResult, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		
		//setting up category specific social media bookmarks
		$twHandle	= $socialCatOnPost[2];
		$fbHandle	= $socialCatOnPost[6];
		$rssFeed	= $socialCatOnPost[10];
		$catSocialBookmarks	=	array("twHandle" => $twHandle, "fbHandle" => $fbHandle, "rssFeed" => $rssFeed);
		callPageTitleInfo( $category, $tagline, $catSocialBookmarks ); 
?>

        <div class="clear"></div>
        <?php callBookmarks($category); ?>
        <div id="blogWrapper">
			<div id="blog">
			<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
	 
				<div class="categoryWrapper">
					<h3 class="singlePostTitle"><?php the_title(); ?></h3>
					<span class="singlePostDate "><?php the_time('F jS, Y') ?> | <?php _e('by'); ?> <?php  the_author(); ?></span>
					<hr class="posthr" />
					<?php callSocialBookmarks(); ?>
					<div class="entry">
						<?php the_post_thumbnail(); ?>
						<?php the_content(); ?>
						<div id="postCats"><?php _e('Posted In&#58;'); ?> <?php the_category(', ') ?> </div><br />
						<p class="postmetadata">
							<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?>
						</p> 
					</div>
			 
					<div class="postNav">
						<div class="postNavPrev">
							<span class="postNavGeneric">&larr; Previous Article</span> <br />
							<?php previous_post_link(' %link') ?>
						</div>
						<div class="postNavNext">
							<span class="postNavGeneric">Next Article &rarr;</span> <br />
							<?php next_post_link(' %link ') ?>
						</div>
					</div> 
                    
					<?php callSocialBookmarks("shareThoughts"); ?>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
		</div>
            </div>
            <?php callSidebar(); ?>
         </div>
		<?php
		get_footer(); 	
?>