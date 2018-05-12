<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */
?>
<?php get_header(); ?>
	<div id="page" class="home-page">
		<div id="content" class="article">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					schema_lite_archive_post();
				endwhile;
				schema_lite_post_navigation();
			endif; ?>
		</div><!-- .article -->
		<?php get_sidebar(); ?>
		</div>
		<?php get_footer(); ?>
