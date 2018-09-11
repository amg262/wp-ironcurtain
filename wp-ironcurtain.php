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


const IRC_TMP    = __DIR__ . '/tmp';
const IRC_FAILED = __DIR__ . '/failed.json';


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

		add_action( 'wp_login_failed', [ $this, 'login_failed' ] );
		$this->foot();
		add_action( 'init', [ $this, 'threat_cpt' ] );

		//add_action( 'admin_init', [ $this, 'exec' ] );
		$this->cloak_status();
		add_action( 'wp_head', [ $this, 'cloak_status' ], 10 );

	}

	public function foot() {

		$this->http_args = [
			//	'username' => $username,
			'referrer' => $_SERVER['HTTP_REFERER'],
			'agent'    => $_SERVER['HTTP_USER_AGENT'],
			'ip'       => $_SERVER['REMOTE_ADDR'],
			'host'     => $_SERVER['REMOTE_HOST'],
			'time'     => date( "Y-m-d H:i:s" ),
			//$_SERVER['REMOTE_HOST'],
		];


		if ( $this->check_tmp() === true ) {
			echo '<style>#login, #loginform { display:none !important; visibility: hidden !important; }</style>';
			//echo   '<script>alert("hi");</script>';
			$ae = '<div style="width:300px;height:300px;display: block;margin:5% auto;text-align: center;">
						<p>
							<h1 style="text-align: center;"><strong>403: Forbidden</strong></h1>
							<br>
							<h5 style="text-align: center;">IP: ' . $this->http_args['ip'] . ' is denied access</h5>
						</p>
					</div>';
			//echo $ae;

			//wp_die( '' );
		}

	}

	public function check_tmp() {

		return file_exists( IRC_TMP ) ? true : false;
	}

	public function cloak_status() {
		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === date( 'j' ) ) {
			$this->tmp( 'on', $this->check_tmp() );
		} elseif ( ( $_GET['cloak'] === 'off' ) && $_GET['key'] === date( 'j' ) ) {
			$this->tmp( 'off', $this->check_tmp() );
		}
	}

	public function tmp( $status, $check ) {

		if ( $status === 'on' ) {
			if ( $check === false ) {
				file_put_contents( IRC_TMP, 'true' );
			}
		} elseif ( $status === 'off' ) {
			if ( $check === true ) {
				unlink( IRC_TMP );
			}
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
	}///

	public function login_failed( $username ) {

		$this->http_args = [
			'username' => $username,
			'referrer' => $_SERVER['HTTP_REFERER'],
			'agent'    => $_SERVER['HTTP_USER_AGENT'],
			'ip'       => $_SERVER['REMOTE_ADDR'],
			'host'     => $_SERVER['REMOTE_HOST'],
			'time'     => date( "Y-m-d H:i:s" ),
			//$_SERVER['REMOTE_HOST'],
		];

		file_put_contents( __DIR__ . '/failed.json', json_encode( $this->http_args ), FILE_APPEND );

		wp_mail( 'andrewmgunn26@gmail.com', mt_rand( 0, 100 ), json_encode( $this->http_args ), '' );
	}

	public function threat_cpt() {

		$labels = [
			"name"          => __( "Threats", "ezdepositslip" ),
			"singular_name" => __( "Threat", "ezdepositslip" ),
		];

		$args = [
			"label"               => __( "Threats", "ezdepositslip" ),
			"labels"              => $labels,
			"description"         => "",
			"public"              => true,
			"publicly_queryable"  => true,
			"show_ui"             => true,
			"show_in_rest"        => true,
			"rest_base"           => "",
			"has_archive"         => true,
			"show_in_menu"        => true,
			"show_in_nav_menus"   => true,
			"exclude_from_search" => true,
			"capability_type"     => "post",
			"map_meta_cap"        => true,
			"hierarchical"        => true,
			"rewrite"             => [ "slug" => "threat", "with_front" => true ],
			"query_var"           => true,
			"menu_icon"           => "dashicons-lock",
			"supports"            => [ "title", "editor", "thumbnail", "revisions", "post-formats" ],
		];

		register_post_type( "threat", $args );
	}


}

$wpic = WP_IronCurtain::getInstance();