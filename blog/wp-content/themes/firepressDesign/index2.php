<?php get_header(); ?>
   
<div id="main">
	<div id="pageTitleWrapper">
    	<div id="pageTitle">
    		Blog Directory 
		</div>
        <div id="titleTagline">
        	Follow The News Journal's columnists and reporters
        </div>    
    </div>
    
    <div class="clear"></div>
<div id="socialBookmarks">
    	FB Like | Twitter Follow | GPlus
    </div>
    <div id="breadCrumbs">
    	Jump to:   <?php wp_list_categories(' | ') ?>
    </div>
  <div id="content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="postAvatarWrapper">
        <div class="postAvatar"><?php echo get_avatar( get_the_author_email(), '80' ); ?></div>
        <div class="postWrapper">
            <h1 class="postTitle"><?php the_title(); ?></h1>
            <p><?php the_content(__('(more...)')); ?>...<?php the_time('F jS, Y') ?></p>
        </div>
    </div>
    <div class="clear"></div>
    
    <hr>
    
    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
  </div>

  <?php get_sidebar(); ?>

  </div>

<div id="delimiter"></div>

<?php get_footer(); ?>