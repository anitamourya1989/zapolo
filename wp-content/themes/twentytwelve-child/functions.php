<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


//Adding custom Fields in settings
add_action('admin_init', 'my_general_section');  
function my_general_section() {  
    add_settings_section(  'my_settings_section', 'Add Background Urls for Images', 'my_section_options_callback', 'general' );

    add_settings_field('option_1','First Left','my_textbox_callback','general','my_settings_section',array('option_1'));
    add_settings_field('option_2','Second Left','my_textbox_callback','general','my_settings_section',array('option_2'));
    add_settings_field('option_3','Third Left','my_textbox_callback','general','my_settings_section',array('option_3'));
    add_settings_field('option_4','Fourth Left','my_textbox_callback','general','my_settings_section',array('option_4'));
    add_settings_field('option_5','Fifth Left','my_textbox_callback','general','my_settings_section',array('option_5'));
    add_settings_field('option_6','First Right','my_textbox_callback','general','my_settings_section',array('option_6'));
    add_settings_field('option_7','Second Right','my_textbox_callback','general','my_settings_section',array('option_7'));
    add_settings_field('option_8','Third Right','my_textbox_callback','general','my_settings_section',array('option_8'));
    add_settings_field('option_9','Fourth Right','my_textbox_callback','general','my_settings_section',array('option_9'));
    add_settings_field('option_10','Fifth Right','my_textbox_callback','general','my_settings_section',array('option_10'));

    register_setting('general','option_1', 'esc_attr');
    register_setting('general','option_2', 'esc_attr');
    register_setting('general','option_3', 'esc_attr');
    register_setting('general','option_4', 'esc_attr');
    register_setting('general','option_5', 'esc_attr');
    register_setting('general','option_6', 'esc_attr');
    register_setting('general','option_7', 'esc_attr');
    register_setting('general','option_8', 'esc_attr');
    register_setting('general','option_9', 'esc_attr');
    register_setting('general','option_10', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '<p>A little message on editing info</p>';  
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}


/*

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
	parent::__construct(
	// Base ID of your widget
	'wpb_widget', 

	// Widget name will appear in UI
	__('Popular Places Locations', 'wpb_widget_domain'), 

	// Widget description
	array( 'description' => __( 'To show Places in home page', 'wpb_widget_domain' ), ) 
	);
}
// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	
	$args = array(
    'smallest'                  => 10, 
    'largest'                   => 10,
    'unit'                      => 'pt', 
    'number'                    => 45,  
    'format'                    => 'array',
    'separator'                 => \\"\n",
    'orderby'                   => 'name', 
    'order'                     => 'ASC',
    'exclude'                   => null, 
    'include'                   => null, 
    'topic_count_text_callback' => default_topic_count_text,
    'link'                      => 'view', 
    'taxonomy'                  => array('post_tag','gd_place_tags'), 
    'echo'                      => false,
	    'child_of'                   => null
	); 

	//$tag = wp_tag_cloud(array('taxonomy' => array('post_tag','gd_place_tags')), 'format=array');
	$tag = wp_tag_cloud($args);

	//print_r($tag);
	echo '<ul class="po_list">';
	foreach ($tag as $key => $value) {
		echo '<li>'.$value.'</li>';
	}
	echo '</ul>';

	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	}
	else {
		$title = __( 'Popular Places', 'wpb_widget_domain' );
	}
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );*/
