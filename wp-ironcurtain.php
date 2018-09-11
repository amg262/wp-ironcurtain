<?php
/*
Plugin Name: WP Iron Curtain
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
		//add_action( 'admin_init', [ $this, 'exec' ] );
		add_action( 'wp_head', [ $this, 'run' ] );
	}


	public function foot() {

		$this->http_args = [
			'username' => $username,
			'referrer' => $_SERVER['HTTP_REFERER'],
			'agent'    => $_SERVER['HTTP_USER_AGENT'],
			'ip'       => $_SERVER['REMOTE_ADDR'],
			'host'     => $_SERVER['REMOTE_HOST'],
			'time'     => date( "Y-m-d H:i:s" ),
			//$_SERVER['REMOTE_HOST'],
		];

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			echo '<style>#login, #loginform { display:none !important; visibility: hidden !important; }</style>';
			//echo   '<script>alert("hi");</script>';
			$ae = '<div style="width:300px;height:300px;display: block;margin:5% auto;text-align: center;">
						<p>
							<h1 style="text-align: center;"><strong>403: Forbidden</strong></h1>
							<br>
							<h5 style="text-align: center;">IP: ' . $this->http_args['ip'] . ' is denied access</h5>
						</p>
					</div>';
			echo $ae;

			wp_die('');

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
	public function exec() {

		if ( ( $_GET['cloak'] === 'on' ) && ( $_GET['key'] === date( 'j' ) ) ) {
			//$this->change_wplogin();
			$cage  = plugins_url( 'irc/cage.gif', __FILE__ );
			$cosby = plugins_url( 'irc/cosby.gif', __FILE__ );

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
				$this->status = true;
				$t            = 'ON';
			} else {
				file_put_contents( __DIR__ . '/tmp', 'true' );
				$this->status = false;
				$t            = 'OFF';
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

	/**
	 *
	 */
	public function run() {

		if ( ( $_GET['cloak'] === 'on' ) && ( $_GET['key'] === date( 'j' ) ) ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}

		} elseif ( ( $_GET['cloak'] === 'off' ) && ( $_GET['key'] === date( 'j' ) ) ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );
		}
	}

	/**
	 *
	 */
	public function change_wplogin() {

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );
			$this->status = false;
		} else {
			unlink( __DIR__ . '/tmp' );
			$this->status = true;
		}
	}

}

$wpic = WP_IronCurtain::getInstance();