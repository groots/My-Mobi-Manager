<?php get_header(); ?>

<div class="pagel" id="content">
<!-- content -->
		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="title_nolink">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="title_nolink">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="title_nolink">Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="title_nolink">Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="title_nolink">Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="title_nolink">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="title_nolink">Blog Archives</h2>
 	  <?php } ?>
	  <div class="clear"></div>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
				<h3 class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<div class="clear"></div>
				<div class="date"><?php the_time('F j, Y') ?> at <?php the_time() ?> &bull; Posted in <?php the_category(', ') ?> <?php edit_post_link('Edit', '| ', ''); ?> &bull; <?php comments_popup_link('No comments yet', '1 Comment', '% Comments'); ?></div>

				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
				<div class="clear"></div>

				<p class="postmetadata"><?php the_tags('Tags: ', ', ', ''); ?></p>

			</div>

		<?php endwhile; ?>

		<div class="pagenavigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			<div class="clear"></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
<!-- content end -->
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>

<?php get_footer(); ?>
