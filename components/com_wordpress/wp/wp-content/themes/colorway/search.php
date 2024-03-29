<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Colorway
 * @since Colorway 1.0
 */ ?>
<?php get_header(); ?>
<!--Start Content Grid-->
<div class="grid_24 content">
     <div class="grid_16 alpha">
          <div class="content-wrap">
               <div class="content-info">
                    <?php if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
               </div>
               <div class="blog" id="blogmain">
                    <h1><?php printf('Search Results for: %s', '' . get_search_query() . '' ); ?></h1>
                    <ul>
                         <!-- Start the Loop. -->
                         <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                         <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                              <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                              <a href="<?php the_permalink(); ?>">
                              <?php the_post_thumbnail( 'post_thumbnail', array('class' => 'postimg'  )); ?>
                              </a>
                              <?php
			} else {
			   echo main_image();
			} 
		  ?>
                              <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                                   <?php the_title(); ?>
                                   </a></h2>
                              Posted on <a href="#">
                              <?php the_time('F j, Y'); ?>
                              </a> by <a href="#">
                              <?php the_author_posts_link() ?>
                              </a> in <a href="#">
                              <?php the_category(', '); ?>
                              </a>
                              <?php the_excerpt(); ?>
                              <?php comments_popup_link('No Comments.', '1 Comment.', '% Comments.'); ?>
                              <a href="<?php the_permalink() ?>">Continue Reading...</a> </li>
                         <!-- End the Loop. -->
                         <?php endwhile; else: ?>
                         <li>
                              <h2>
                                   <?php echo ('Nothing Found'); ?>
                              </h2>
                              <p>
                                   <?php echo ('Sorry, but nothing matched your search criteria. Please try again with some different keywords.'); ?>
                              </p>
                              <?php get_search_form(); ?>
                         </li>
                         <?php endif; ?>
                    </ul>
               </div>
               <div class="folio-page-info">
                    <!--<label>Page:</label>-->
                    <?php /* Display navigation to next/previous pages when applicable */ ?>
                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                    <?php next_posts_link('&larr; Older posts'); ?>
                    <?php previous_posts_link('Newer posts &rarr;'); ?>
                    <?php endif; ?>
               </div>
          </div>
     </div>
     <?php get_sidebar(); ?>
</div>
<div class="clear"></div>
<!--End Content Grid-->
</div>
<!--End Container Div-->
<?php get_footer(); ?>
