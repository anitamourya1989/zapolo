<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<ul class="grid">
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a11.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a12.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a13.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a21.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a22.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a23.jpg"></a></li>
	</ul>

	<ul class="grid right">
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a11.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a12.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a13.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a21.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a22.jpg"></a></li>
	   <li><a href="#"><img src="http://pics.cssbakery.com/pics/pinkpoison/orchid_pink_files/a23.jpg"></a></li>
	</ul>

<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
		<hgroup>
			<?php
			if( is_user_logged_in() ){
				$userdata = wp_get_current_user();
                echo get_avatar( $userdata->ID, 32 );
                echo __('Welcome') . ', ' . $userdata->display_name;
                echo '<a class="logout" href="<?php echo wp_logout_url( home_url() );?>">Logout</a>';
			} else{
				jfb_output_facebook_btn();
			}
			?>
		</hgroup>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">