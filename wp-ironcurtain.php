<?php
/*
Plugin Name: Wp Iron Curtain
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Prevent any website visitor from viewing, accessing, or using the wp-login form to log in to the site.
Version: 1.2
Author: amg26
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
 */

namespace Netraa\IRC;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_IRC_VERSION', '1.0.1' );
define( 'WP_IRC_DB', '1.0.1' );
define( 'WP_IRC_TABLE', 'wp_irc' );
define( 'WP_IRC_BULID', 'prod' );
define( 'WP_IRC_FILE', __FILE__ );
define( 'WP_IRC_URL', plugins_url( '', __FILE__ ) );




/**
 * Autoloader
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 *
 *  * @since 1.0.0
 */
try {
	spl_autoload_register( function ( $class ) {
		// project-specific namespace prefix
		// base directory for the namespace prefix
		$prefix   = __NAMESPACE__;
		$base_dir = __DIR__ . '/includes/';
		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}
		// get the relative class name
		$relative_class = substr( $class, $len );
		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	} );
} catch ( \Exception $e ) {
}


/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {
	$bom           = Plugin::get_instance();
	$bom_shortcode = Shortcode::get_instance();
	$bom_admin     = Admin::get_instance();
	$bom_rest      = Endpoint\Example::get_instance();
//	$bom_post      = Post::get_instance();

	$bom_set = new Settings();

}

add_action( 'plugins_loaded', 'Netraa\\IRC\\init' );


/**
 * Register the widget
 *
 * @since 1.0.0
 */
function widget_init() {
	return register_widget( new Widget );
}

add_action( 'widgets_init', 'Netraa\\IRC\\widget_init' );


/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Netraa\\IRC\\Plugin', 'activate' ] );
register_activation_hook( __FILE__, [ 'Netraa\\IRC\\Plugin', 'install_database' ] );
register_deactivation_hook( __FILE__, [ 'Netraa\\IRC\\Plugin', 'deactivate' ] );
