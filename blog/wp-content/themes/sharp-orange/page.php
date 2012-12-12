<?php get_header(); ?>

<div class="pagel" id="content">
<!-- content -->
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>
				
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</div>
				<div class="clear"></div>
			</div>

		<?php endwhile; ?>
	<?php endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
<!-- content end -->
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>

<?php get_footer(); ?>
