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

		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );
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
	public function load_assets() {

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
	}


	/**
	 *
	 */
	public function run() {

		$opt  = get_option( 'wcb_settings' );

		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

		if ( ( $_GET['cloak'] === 'reset' ) ) {

			file_put_contents( __DIR__ . '/tmp', 'true' );
			$headers = [ 'Content-Type: text/html; charset=UTF-8' ];


			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				$status = 'ON';
			} else {
				$status = 'OFF';
			}
			//update_option( 'wcb_key', null );

			//if ( get_option( 'wcb_key' ) === null ) {
			update_option( 'wcb_key', mt_rand( 0, 1000 ) );

			$opt['key2'] = (string) get_option( 'wcb_key' );


			$uri = site_url() . '/?cloak=on&key=' . $opt['key2'];
			update_option( 'wcb_settings', $opt );
			//}
			$html = '<p><strong>New key: </strong>' . $opt['key2'] . '</p>' . '<p><strong>Status: </strong>' . $status . '</p>' . '<p><strong>Click for ON: </strong>' . site_url() . '/?cloak=on&key=' . $opt['key2'] . '</p>' . '<p><strong>Click for OFF: </strong>' . site_url() . '/?cloak=off&key=' . $opt['key2'] . '</p>' . site_url() . '/?cloak=off&key=' . $opt['key2'];

			wp_mail( $opt['email'], 'Cloak key reset for ' . site_url(), $html, $headers );

		}
		if ( ( $_GET['cloak'] === 'email' ) || ( $_GET['cloak'] === 'status' ) ) {
			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				echo '<h5>Cloak is <strong>ON</strong></h5>';
			} else {
				echo '<h5>Cloak is <strong>OFF</strong></h5>';
			}

			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				$status = 'ON';
			} else {
				$status = 'OFF';
			}

			$headers = [ 'Content-Type: text/html; charset=UTF-8' ];

			$html = '<p><strong>Key: </strong>' . $opt['key2'] . '</p>' . '<p><strong>Status: </strong>' . $status . '</p>' . '<p><strong>Click for ON: </strong>' . site_url() . '/?cloak=on&key=' . $opt['key2'] . '</p>' . '<p><strong>Click for OFF: </strong>' . site_url() . '/?cloak=off&key=' . $opt['key2'] . '</p>' . site_url() . '/?cloak=off&key=' . $opt['key2'];

			wp_mail( $opt['email'], 'Cloak key status for ' . site_url(), $html, $headers );

		}

		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['key2'] ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}

		} elseif ( ( $_GET['cloak'] === 'off' ) && $_GET['key'] === $opt['key2'] ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links(
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