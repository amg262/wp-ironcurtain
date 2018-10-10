<?php
/*
Plugin Name: Wp Iron Curtain
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Prevent any website visitor from viewing, accessing, or using the wp-login form to log in to the site.
Version: 1.1
Author: amg26
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}


cloak_check();
cloak_expiration_check();
load_irc_login();
function load_irc_login() {

}

function cloak_check() {
	$settings = get_option( 'wcb_settings' );

	if ( $settings['cloak'] === 'On' ) {
		require __DIR__ . '/wp-irc-login.php';
		add_action( 'login_form', 'myplugin_add_login_fields' );

		//return true;
	}
	$exp = date( 'm/d/Y H:i:s', time() );

	$timeout = get_option( '_transient_timeout_wcb_timelimit' );


	if ( time() < $timeout ) {

		echo 'poopy';
	}
	echo 'tool';
	echo $exp;
}

function cloak_expiration_check() {
	$settings = get_option( 'wcb_settings' );

	$exp = date( 'm/d/Y H:i:s', get_option( '_transient_timeout_wcb_timelimit' ) );
	echo 'boobs';
	echo $exp;
}

// Scheduled Action Hook
function cloak_expire() {


}

// Schedule Cron Job Event
function cloak_expire_check() {
	if ( ! wp_next_scheduled( 'cloak_expire' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'daily', 'cloak_expire' );
	}
}

add_action( 'wp', 'cloak_expire_check' );

/**
 * Class WP_IronCurtain
 */
class WPIRC {


	/**
	 * @var null
	 */
	protected static $instance = null;
	/**
	 * @var bool
	 */
	public $status = false;
	/**
	 * @var array
	 */
	protected $http_args = [];
	/**
	 * @var array
	 */
	protected $hosts = [];

	/**
	 * WP_IronCurtain constructor.
	 */
	protected function __construct() {

		require __DIR__ . '/Settings.php';
		$settings = new Settings();
		//add_action( 'wp_login_failed', [ $this, 'login_failed' ] );
		$this->foot();
		//add_action( 'init', [ $this, 'check_acf' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );

		add_action( 'wp_footer', [ $this, 'foot' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );
		//add_action( 'admin_init', [ $this, 'exec' ] );
		add_action( 'wp_head', [ $this, 'run' ] );

		add_action( 'login_form', 'myplugin_add_login_fields' );
		add_shortcode( 'ip', [ $this, 'ip_shortcode' ] );

		//add_action( 'init', [ $this, 'exec' ] );
	}

	/**
	 *
	 */
	public function foot() {

		//echo //json_encode( get_option( 'wcb_settings' ) );

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			echo
				'<script>jQuery(document).ready(function($) { 
				  swal({
				  title: "Are you sure?",
				  text: "' . $_SERVER["REMOTE_ADDR"] . '",
				  icon: "warning",
				  buttons: true,
				})

				});</script>';

			echo '<style>#loginform, p#nav, p#backtoblog { display:none !important; visibility: hidden !important; }

				.login h1 a {background-image:url(irc/cage.gif)};
				</style>';

		}
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	// [bartag foo="foo-value"]
	function ip_shortcode( $atts ) {
		return '<h4 id="irc_addr">' . $_SERVER['REMOTE_ADDR'] . '</h4>';
	}
// [bartag foo="foo-value"]

	/**
	 *
	 */
	function logout_cloak() {

		// your code
		$opts = get_option( 'wcb_settings' );

		if ( $opts['radio'] === 'yes' ) {
			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}
		}

	}
	

	/**
	 *
	 */
	public
	function exec() {

		$opt = get_option( 'wcb_settings' );
		if ( ( $_GET['cloak'] === 'status' ) ) {
			echo 'nigs';

			echo '<h1>' . $opt['cloak'] . '</h1>';

		}

		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}
		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['key'] ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
				$this->status = true;
				$t            = 'ON';
			} else {
				file_put_contents( __DIR__ . '/tmp', 'true' );
				$this->status = false;
				$t            = 'OFF';
			}

		}
	}

	/**
	 *
	 */
	public
	function run() {

		$opt = get_option( 'wcb_settings' );
		if ( ( $_GET['cloak'] === 'status' ) ) {

			echo 'nigs';
			echo '<h1>' . $opt['cloak'] . '</h1>';

		}

		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['Key'] ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}

		} elseif ( ( $_GET['cloak'] === 'off' ) && $_GET['key'] === $opt['key'] ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public
	function plugin_links(
		$actions, $plugin_file
	) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [

				'settings' => '<a href="admin.php?page=wp-irc-admin">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}

}

$wpic = WPIRC::getInstance();