<?php
/**
 * @package aThemes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<div class="entry-meta">
		<?php
			$category = get_the_category(); 
			if ( $category[0] ) {
				echo '<span class="cat-links"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></span>';
			}
			athemes_posted_on();
		?>
		<!-- .entry-meta --></div>

		<h1 class="entry-title"><?php the_title(); ?></h1>
	<!-- .entry-header --></header>

	<div class="clearfix entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'athemes' ),
				'after'  => '</div>',
			) );
		?>
	<!-- .entry-content --></div>

	<footer class="entry-meta entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'athemes' ) );

			if ( '' != $tag_list ) {
				$meta_text = __( '<span class="tags-links"><i class="ico-tags"></i> %1$s</span>', 'athemes' );
			}

			printf(
				$meta_text,
				$tag_list
			);
		?>
	<!-- .entry-meta --></footer>
<!-- #post-<?php the_ID(); ?> --></article>
