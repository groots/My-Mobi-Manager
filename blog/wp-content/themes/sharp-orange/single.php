<?php get_header(); ?>

<div class="pagel">
<!-- content -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2 class="title_nolink"><?php the_title(); ?></h2>
			<div class="clear"></div>
			
			<div class="date"><?php the_time('F j, Y') ?> at <?php the_time() ?> &bull; Posted in <?php the_category(', ') ?> <?php edit_post_link('Edit', '| ', ''); ?> &bull; <?php comments_popup_link('No comments yet', '1 Comment', '% Comments'); ?></div>

			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<div class="clear"></div>
				<div class="separate"></div>
				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

<script src="http://feeds.feedburner.com/~s/making-the-web?i=<?php the_permalink() ?>" type="text/javascript" charset="utf-8"></script>

			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
<!-- content end -->
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>

<?php get_footer(); ?>
