<?php
/**
 * The Template for displaying all single posts.
 *
 * @package aThemes
 */

get_header();
$at_options = get_option('at_options');
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php
				if ( $at_options['post_author_profile'] == '1' ) :
					get_template_part( 'profile' );
				endif;
			?>

			<?php athemes_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		<!-- #content --></div>
	<!-- #primary --></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>