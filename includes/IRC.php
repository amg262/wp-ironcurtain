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

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}

/**
 * Class WP_IronCurtain
 */
class IRC {


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

		//require __DIR__ . '/Settings.php';
		//$settings = new Settings();
		//add_action( 'wp_login_failed', [ $this, 'login_failed' ] );
		//$this->foot();
		//add_action( 'init', [ $this, 'check_acf' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );

		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );

		//add_action( 'wp_footer', [ $this, 'foot' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );
		//add_action( 'admin_init', [ $this, 'exec' ] );
		add_action( 'wp_head', [ $this, 'run' ] );

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			add_action( 'login_enqueue_scripts', [ $this, 'my_login' ] );
		}
		//add_action( 'init', [ $this, 'exec' ] );
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
//
//	/**
//	 *
//	 */
//	public function foot() {
//
//		echo json_encode( get_option( 'wcb_settings' ) );
//
//		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
//			echo
//			'<script>jQuery(document).ready(function($) {
//				 console.log("Cloak is on");
//				 alert("boo");
//				});</script>';
//
//		}
//	}

	public function my_login() {

		$opt = get_option( 'wcb_settings' );


		echo '<style>' . $opt['css'] . '</style>';
		echo '<h1 style="padding: 10px">' . $opt['html'] . '</h1>';

		if ( $opt['ip'] === 'yes' ) {
			echo '<h2 style="text-align: center;padding: 10px;">' . $_SERVER['REMOTE_ADDR'] . '</h2>';
		}
	}

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
	function load_assets() {

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
	}

	/**
	 *
	 */
	public
	function exec() {

		$opt = get_option( 'wcb_settings' );

		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

		if ( $_GET['cloak'] === 'status' ) {
			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				echo '<h5>Cloak is <strong>ON</strong></h5>';
			} else {
				echo '<h5>Cloak is <strong>OFF</strong></h5>';
			}
		}

		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['key'] ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			} else {
				file_put_contents( __DIR__ . '/tmp', 'true' );
			}

		}
	}

	/**
	 *
	 */
	public
	function run() {

		$opt = get_option( 'wcb_settings' );

		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

		if ( $_GET['cloak'] === 'status' ) {
			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				echo '<h5>Cloak is <strong>ON</strong></h5>';
			} else {
				echo '<h5>Cloak is <strong>OFF</strong></h5>';
			}
		}

		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['key'] ) {

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