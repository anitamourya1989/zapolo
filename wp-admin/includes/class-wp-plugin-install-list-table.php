<?php
/**
 * Plugin Installer List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
class WP_Plugin_Install_List_Table extends WP_List_Table {

	var $order = 'ASC';
	var $orderby = null;
	var $groups = array();

	public function ajax_user_can() {
		return current_user_can('install_plugins');
	}

	/**
	 * Return a list of slugs of installed plugins, if known.
	 *
	 * Uses the transient data from the updates API to determine the slugs of
	 * known installed plugins. This might be better elsewhere, perhaps even
	 * within get_plugins().
	 *
	 * @since 4.0.0
	 */
	protected function get_installed_plugin_slugs() {
		$slugs = array();

		$plugin_info = get_site_transient( 'update_plugins' );
		if ( isset( $plugin_info->no_update ) ) {
			foreach ( $plugin_info->no_update as $plugin ) {
				$slugs[] = $plugin->slug;
			}
		}

		if ( isset( $plugin_info->response ) ) {
			foreach ( $plugin_info->response as $plugin ) {
				$slugs[] = $plugin->slug;
			}
		}

		return $slugs;
	}

	public function prepare_items() {
		include( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		global $tabs, $tab, $paged, $type, $term;

		wp_reset_vars( array( 'tab' ) );

		$paged = $this->get_pagenum();

		$per_page = 30;

		// These are the tabs which are shown on the page
		$tabs = array();

		if ( 'search' == $tab )
			$tabs['search']	= __( 'Search Results' );
		$tabs['featured']  = _x( 'Featured', 'Plugin Installer' );
		$tabs['popular']   = _x( 'Popular', 'Plugin Installer' );
		$tabs['new']       = _x( 'Newest', 'Plugin Installer' );
		$tabs['favorites'] = _x( 'Favorites', 'Plugin Installer' );
		if ( $tab === 'beta' || false !== strpos( $GLOBALS['wp_version'], '-' ) ) {
			$tabs['beta']      = _x( 'Beta Testing', 'Plugin Installer' );
		}

		$nonmenu_tabs = array( 'upload', 'plugin-information' ); //Valid actions to perform which do not have a Menu item.

		/**
		 * Filter the tabs shown on the Plugin Install screen.
		 *
		 * @since 2.7.0
		 *
		 * @param array $tabs The tabs shown on the Plugin Install screen. Defaults are 'dashboard', 'search',
		 *                    'upload', 'featured', 'popular', 'new', and 'favorites'.
		 */
		$tabs = apply_filters( 'install_plugins_tabs', $tabs );

		/**
		 * Filter tabs not associated with a menu item on the Plugin Install screen.
		 *
		 * @since 2.7.0
		 *
		 * @param array $nonmenu_tabs The tabs that don't have a Menu item on the Plugin Install screen.
		 */
		$nonmenu_tabs = apply_filters( 'install_plugins_nonmenu_tabs', $nonmenu_tabs );

		// If a non-valid menu tab has been selected, And it's not a non-menu action.
		if ( empty( $tab ) || ( !isset( $tabs[ $tab ] ) && !in_array( $tab, (array) $nonmenu_tabs ) ) )
			$tab = key( $tabs );

		$args = array(
			'page' => $paged,
			'per_page' => $per_page,
			'fields' => array( 'last_updated' => true, 'downloaded' => true ),
			// Send the locale and installed plugin slugs to the API so it can provide context-sensitive results.
			'locale' => get_locale(),
			'installed_plugins' => $this->get_installed_plugin_slugs(),
		);

		switch ( $tab ) {
			case 'search':
				$type = isset( $_REQUEST['type'] ) ? wp_unslash( $_REQUEST['type'] ) : 'term';
				$term = isset( $_REQUEST['s'] ) ? wp_unslash( $_REQUEST['s'] ) : '';

				switch ( $type ) {
					case 'tag':
						$args['tag'] = sanitize_title_with_dashes( $term );
						break;
					case 'term':
						$args['search'] = $term;
						break;
					case 'author':
						$args['author'] = $term;
						break;
				}

				add_action( 'install_plugins_table_header', 'install_search_form', 10, 0 );
				break;

			case 'featured':
				$args['fields']['group'] = true;
				$this->orderby = 'group';
				// No break!
			case 'popular':
			case 'new':
			case 'beta':
				$args['browse'] = $tab;
				break;

			case 'favorites':
				$user = isset( $_GET['user'] ) ? wp_unslash( $_GET['user'] ) : get_user_option( 'wporg_favorites' );
				update_user_meta( get_current_user_id(), 'wporg_favorites', $user );
				if ( $user )
					$args['user'] = $user;
				else
					$args = false;

				add_action( 'install_plugins_favorites', 'install_plugins_favorites_form', 9, 0 );
				break;

			default:
				$args = false;
				break;
		}

		/**
		 * Filter API request arguments for each Plugin Install screen tab.
		 *
		 * The dynamic portion of the hook name, $tab, refers to the plugin install tabs.
		 * Default tabs are 'dashboard', 'search', 'upload', 'featured', 'popular', 'new',
		 * and 'favorites'.
		 *
		 * @since 3.7.0
		 *
		 * @param array|bool $args Plugin Install API arguments.
		 */
		$args = apply_filters( "install_plugins_table_api_args_$tab", $args );

		if ( !$args )
			return;

		$api = plugins_api( 'query_plugins', $args );

		if ( is_wp_error( $api ) )
			wp_die( $api->get_error_message() . '</p> <p class="hide-if-no-js"><a href="#" onclick="document.location.reload(); return false;">' . __( 'Try again' ) . '</a>' );

		$this->items = $api->plugins;

		if ( $this->orderby ) {
			uasort( $this->items, array( $this, '_order_callback' ) );
		}

		$this->set_pagination_args( array(
			'total_items' => $api->info['results'],
			'per_page' => $args['per_page'],
		) );

		if ( isset( $api->info['groups'] ) )
			$this->groups = $api->info['groups'];
	}

	public function no_items() {
		_e( 'No plugins match your request.' );
	}

	protected function get_views() {
		global $tabs, $tab;

		$display_tabs = array();
		foreach ( (array) $tabs as $action => $text ) {
			$class = 'wp-filter-link';
			$class .= ( $action == $tab ) ? ' current' : '';
			$href = self_admin_url('plugin-install.php?tab=' . $action);
			$display_tabs['plugin-install-'.$action] = "<a href='$href' class='$class'>$text</a>";
		}

		return $display_tabs;
	}

	/**
	 * Override parent views so we can use the filter bar display.
	 */
	public function views() {
		$views = $this->get_views();

		/** This filter is documented in wp-admin/inclues/class-wp-list-table.php */
		$views = apply_filters( "views_{$this->screen->id}", $views );

?>
<div class="wp-filter">
	<ul class="wp-filter-links">
		<?php
		if ( ! empty( $views ) ) {
			foreach ( $views as $class => $view ) {
				$views[ $class ] = "\t<li class='$class'>$view";
			}
			echo implode( " </li>\n", $views ) . "</li>\n";
		}
		?>
	</ul>

	<?php install_search_form( false ); ?>
</div>
<?php
	}

	/**
	 * Override the parent display() so we can provide a different container.
	 */
	public function display() {
		$singular = $this->_args['singular'];

		$data_attr = '';

		if ( $singular ) {
			$data_attr = " data-wp-lists='list:$singular'";
		}

		$this->display_tablenav( 'top' );

?>
<div class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">

	<div id="the-list"<?php echo $data_attr; ?>>
		<?php $this->display_rows_or_placeholder(); ?>
	</div>
</div>
<?php
		$this->display_tablenav( 'bottom' );
	}

	protected function display_tablenav( $which ) {
		if ( 'top' ==  $which ) { ?>
			<div class="tablenav top">
				<div class="alignleft actions">
					<?php
					/**
					 * Fires before the Plugin Install table header pagination is displayed.
					 *
					 * @since 2.7.0
					 */
					do_action( 'install_plugins_table_header' ); ?>
				</div>
				<?php $this->pagination( $which ); ?>
				<br class="clear" />
			</div>
		<?php } else { ?>
			<div class="tablenav bottom">
				<?php $this->pagination( $which ); ?>
				<br class="clear" />
			</div>
		<?php
		}
	}

	protected function get_table_classes() {
		return array( 'widefat', $this->_args['plural'] );
	}

	public function get_columns() {
		return array(
			'name'        => _x( 'Name', 'plugin name' ),
			'version'     => __( 'Version' ),
			'rating'      => __( 'Rating' ),
			'description' => __( 'Description' ),
		);
	}

	public function _order_callback( $plugin_a, $plugin_b ) {

		$orderby = $this->orderby;
		if ( !isset( $plugin_a->$orderby, $plugin_b->$orderby ) )
			return 0;

		$a = $plugin_a->$orderby;
		$b = $plugin_b->$orderby;

		if ( $a == $b )
			return 0;

		if ( 'DESC' == $this->order )
			return ( $a < $b ) ? 1 : -1;
		else
			return ( $a < $b ) ? -1 : 1;
	}


	public function display_rows() {
		$plugins_allowedtags = array(
			'a' => array( 'href' => array(),'title' => array(), 'target' => array() ),
			'abbr' => array( 'title' => array() ),'acronym' => array( 'title' => array() ),
			'code' => array(), 'pre' => array(), 'em' => array(),'strong' => array(),
			'ul' => array(), 'ol' => array(), 'li' => array(), 'p' => array(), 'br' => array()
		);

		list( $columns, $hidden ) = $this->get_column_info();

		$style = array();
		foreach ( $columns as $column_name => $column_display_name ) {
			$style[ $column_name ] = in_array( $column_name, $hidden ) ? 'style="display:none;"' : '';
		}

		$group = null;

		foreach ( (array) $this->items as $plugin ) {
			if ( is_object( $plugin ) )
				$plugin = (array) $plugin;

			// Display the group heading if there is one
			if ( isset( $plugin['group'] ) && $plugin['group'] != $group ) {
				if ( isset( $this->groups[ $plugin['group'] ] ) )
					$group_name = translate( $this->groups[ $plugin['group'] ] ); // Does this need context?
				else
					$group_name = $plugin['group'];

				// Starting a new group, close off the divs of the last one
				if ( ! empty( $group ) ) {
					echo '</div></div>';
				}

				echo '<div class="plugin-group"><h3>' . esc_html( $group_name ) . '</h3>';
				// needs an extra wrapping div for nth-child selectors to work
				echo '<div class="plugin-items">';

				$group = $plugin['group'];
			}
			$title = wp_kses( $plugin['name'], $plugins_allowedtags );

			//Remove any HTML from the description.
			$description = strip_tags( $plugin['short_description'] );
			$version = wp_kses( $plugin['version'], $plugins_allowedtags );

			$name = strip_tags( $title . ' ' . $version );

			$author = $plugin['author'];

			if ( ! empty( $author ) ) {
				$author = ' <cite>' . sprintf( __( 'By %s' ), $author ) . '</cite>';
			}

			$author = wp_kses( $author, $plugins_allowedtags );

			$action_links = array();

			if ( current_user_can( 'install_plugins' ) || current_user_can( 'update_plugins' ) ) {
				$status = install_plugin_install_status( $plugin );

				switch ( $status['status'] ) {
					case 'install':
						if ( $status['url'] ) {
							$action_links[] = '<a class="install-now button" href="' . $status['url'] . '" aria-labelledby="' . $plugin['slug'] . '">' . __( 'Install Now' ) . '</a>';
						}

						break;
					case 'update_available':
						if ( $status['url'] ) {
							$action_links[] = '<a class="button" href="' . $status['url'] . '" aria-labelledby="' . $plugin['slug'] . '">' . __( 'Update Now' ) . '</a>';
						}

						break;
					case 'latest_installed':
					case 'newer_installed':
						$action_links[] = '<span class="button button-disabled" title="' . esc_attr__( 'This plugin is already installed and is up to date' ) . ' ">' . _x( 'Installed', 'plugin' ) . '</span>';
						break;
				}
			}

			$details_link   = self_admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin['slug'] .
								'&amp;TB_iframe=true&amp;width=600&amp;height=550' );

			$action_links[] = '<a href="' . esc_url( $details_link ) . '" class="thickbox" aria-labelledby="' . $plugin['slug'] . '" data-title="' . esc_attr( $name ) . '">' . __( 'More Details' ) . '</a>';


			/**
			 * Filter the install action links for a plugin.
			 *
			 * @since 2.7.0
			 *
			 * @param array $action_links An array of plugin action hyperlinks. Defaults are links to Details and Install Now.
			 * @param array $plugin       The plugin currently being listed.
			 */
			$action_links = apply_filters( 'plugin_install_action_links', $action_links, $plugin );
		?>
		<div class="plugin-card">
			<div class="plugin-card-top">
				<div class="name column-name"<?php echo $style['name']; ?>>
					<h4><a href="<?php echo esc_url( $details_link ) ?>" class="thickbox"><?php echo $title; ?></a></h4>
					<div class="action-links">
						<?php
							if ( ! empty( $action_links ) ) {
								echo '<ul class="plugin-action-buttons"><li>' . implode( '</li><li>', $action_links ) . '</li>';
							}
						?>
					</div>
				</div>
				<div class="desc column-description"<?php echo $style['description']; ?>>
					<p><?php echo $description ?></p>
					<p class="authors"><?php echo $author; ?></p>
				</div>
			</div>
			<div class="plugin-card-bottom">
				<div class="vers column-rating"<?php echo $style['rating']; ?>>
					<?php wp_star_rating( array( 'rating' => $plugin['rating'], 'type' => 'percent', 'number' => $plugin['num_ratings'] ) ); ?>
					<span class="num-ratings">(<?php echo number_format_i18n( $plugin['num_ratings'] ); ?>)</span>
				</div>
				<div class="column-updated">
					<strong><?php _e( 'Last Updated:' ); ?></strong> <span title="<?php echo esc_attr( $plugin['last_updated'] ); ?>">
						<?php printf( __( '%s ago' ), human_time_diff( strtotime( $plugin['last_updated'] ) ) ); ?>
					</span>
				</div>
				<div class="column-downloaded">
					<?php echo sprintf( _n( '%s download', '%s downloads', $plugin['downloaded'] ), number_format_i18n( $plugin['downloaded'] ) ); ?>
				</div>
				<div class="column-compatibility">
					<?php
					if ( ! empty( $plugin['tested'] ) && version_compare( substr( $GLOBALS['wp_version'], 0, strlen( $plugin['tested'] ) ), $plugin['tested'], '>' ) ) {
						echo  __( '<strong>Untested</strong> with your install ');
					} elseif ( ! empty( $plugin['requires'] ) && version_compare( substr( $GLOBALS['wp_version'], 0, strlen( $plugin['requires'] ) ), $plugin['requires'], '<' ) ) {
						echo __( '<strong>Incompatible</strong> with your install ');
					} else {
						echo __( '<strong>Compatible</strong> with your install ');
					}
					?>
				</div>
			</div>
		</div>
		<?php
		}
	}
}
