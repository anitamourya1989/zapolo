<?php
/**
 * @package aThemes
 */
$at_options = get_option('at_options');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<?php if ( $at_options['posts_mode'] == 'posts_excerpt' ) : ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail( 'thumb-featured', array( 'class' => 'visible-desktop' ) ); ?>
				<?php the_post_thumbnail( 'thumb-featured-alt', array( 'class' => 'hidden-desktop' ) ); ?>
			</a>
		</div>
		<?php endif; ?>

		<header class="entry-header <?php if ( has_post_thumbnail() ) : echo "header-thumb"; endif; ?>">
			<div class="entry-meta">
			<?php
				$category = get_the_category(); 
				if ( $category[0] ) {
					echo '<span class="cat-links"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></span>';
				}
			?>
			<!-- .entry-meta --></div>

			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<!-- .entry-header --></header>

		<?php $entry_class = ( has_post_thumbnail() ) ? 'summary' : 'content'; ?>
		<div class="entry-<?php echo $entry_class; ?>">
			<?php the_excerpt(); ?>
		<!-- .entry-<?php echo $entry_class; ?> --></div>

	<?php else : ?>

		<header class="entry-header">
			<div class="entry-meta">
			<?php
				$category = get_the_category(); 
				if ( $category[0] ) {
					echo '<span class="cat-links"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></span>';
				}
			?>
			<!-- .entry-meta --></div>

			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<!-- .entry-header --></header>

		<div class="clearfix entry-content">
			<?php the_content( __( 'Continue Reading <span class="meta-nav">&rarr;</span>', 'athemes' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'athemes' ), 'after' => '</div>' ) ); ?>
		<!-- .entry-content --></div>

		<footer class="entry-meta entry-footer">
			<?php if ( 'post' == get_post_type() ) : ?>
				<?php
					$categories_list = get_the_category_list( __( ', ', 'athemes' ) );
					if ( $categories_list && athemes_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( '<i class="ico-folder"></i> %1$s', 'athemes' ), $categories_list ); ?>
				</span>
				<?php endif; ?>

				<?php
					$tags_list = get_the_tag_list( '', __( ', ', 'athemes' ) );
					if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( '<i class="ico-tags"></i> %1$s', 'athemes' ), $tags_list ); ?>
				</span>
				<?php endif; ?>
			<?php endif; ?>
		<!-- .entry-footer --></footer>
	<?php endif; ?>
<!-- #post-<?php the_ID(); ?>--></article>