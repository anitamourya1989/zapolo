<?php
/**
 * The template part for displaying post author profile.
 *
 * @package aThemes
 */
?>

<div class="clearfix author-info">
	<div class="author-photo"><?php echo get_avatar( get_the_author_id() , 75 ); ?></div>
	<div class="author-content">
		<h3><?php the_author(); ?></h3>
		<p><?php the_author_meta( 'description' ); ?></p>
		<div class="author-links">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="me"><?php _e( 'More Articles', 'athemes' ); ?></a>

			<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			<a href="http://twitter.com/<?php echo get_the_author_meta( 'twitter' ); ?>"><?php _e( 'Twitter', 'athemes' ); ?></a>
			<?php endif; ?>

			<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			<a href="https://facebook.com/<?php echo get_the_author_meta( 'facebook' ); ?>"><?php _e( 'Facebook', 'athemes' ); ?></a>
			<?php endif; ?>

			<?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
			<a href="http://linkedin.com/in/<?php echo get_the_author_meta( 'linkedin' ); ?>"><?php _e( 'LinkedIn', 'athemes' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
<!-- .author-info --></div>