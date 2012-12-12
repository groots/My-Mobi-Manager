<?php 
	
	get_header();  
	//getting general category information (id and name)
	$catTitle	=  single_cat_title("", false);
	$catId		= get_cat_ID($catTitle);
	
	//storing category description into tagline variable
	$tagline	= category_description($catId);
	
	//setting up category specific social media bookmarks
	$twHandle	= MetaData::get_custom('Twitter Handle');
	$fbHandle	= MetaData::get_custom('Facebook Account');
	$rssFeed	= MetaData::get_custom('RSS Feed');
	$catSocialBookmarks	=	array("twHandle" => $twHandle, "fbHandle" => $fbHandle, "rssFeed" => $rssFeed);
	callPageTitleInfo($catTitle, $tagline, $catSocialBookmarks); ?>
	<div class="clear"></div>
	<?php
		callBookmarks($catTitle);
	?>
	<div id="blogWrapper">
	<div class="categoryWrapper">
	<?php 
		//select posts in this category, and of a specified content type
		$posts = get_posts( array( 'category' =>$catId, 'post_type' => 'post' ) ); 
		$numPosts = count($posts);
		$c = 0;
		foreach($posts as $post) : // begin cycle through posts of this category
			setup_postdata($post); //set up post data for use in the loop (enables the_title(), etc without specifying a post ID)
	?>
				<div class="cpPostWrapper">
					<h1 class="cpPostTitle">
					<?php 
						$subCats = getSubCats();
						foreach ($subCats as $subCat)
						{
							if ($subCat == $cat )
							{
								//echo "$subCat";	
							}
						}
					
					the_post_thumbnail();
					echo "<a href='" . get_permalink($post->ID) . "'>" . $post->post_title ?></a></h1>
					<span class="singlePostDate "><?php the_time('F jS, Y') ?> | <?php _e('By'); ?> <?php  the_author(); ?></span>
					<div class="cpPost"><?php echo substr(strip_tags($post->post_content), 0, 200); ?>...</div>
				</div>
			<div class="clear"></div>
			<?php
				if(($c+1) != $numPosts) { 
					echo "<div class='hr'></div>";
				}
				$c++;
			if ($c == $numOfCats) break;
			endforeach;
		?>
		
	</div>
		</div>
		<?php callSidebar(); ?>
	 </div>        
<?php 
	get_footer(); 
 ?>