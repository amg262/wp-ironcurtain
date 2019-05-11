<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */


class Settings {

	private $settings_api;

	function __construct() {

		require __DIR__ . '/SettingsAPI.php';
		$this->settings_api = new SettingsAPI();

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();

	}

	function get_settings_sections() {

		$sections = [

			[
				'id'    => 'wcb_links',
				'title' => __( 'Links', 'wedevs' ),
			],
			[
				'id'    => 'wcb_settings',
				'title' => __( 'Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_styles',
				'title' => __( 'Styles', 'wedevs' ),
			],

		];

		return $sections;
	}


	function get_n($int) {
		$da = new DateTime();

		if ($int === -1) {
			$tt = time();
		} else {
			$tt = ( time() + ( HOUR_IN_SECONDS * $int ) );
		}

		$ad = $da->setTimestamp($tt);
		echo $da->format( 'm/d/y H:i:s' );


		return $da->format( 'm/d/y H:i:s' );

	}
	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		//var_dump( get_option( 'wcb_settings' ) );

		//var_dump( get_option( 'wcb_settings' ) );

		$opt = get_option( 'wcb_settings' );

		$t = time() + ( 30 * HOUR_IN_SECONDS );

		$aa = current_time( 'm/d/y h:m:s' );
		$sf = time();

		$da = new DateTime();
		$ad = $da->setTimestamp( time() );

		$ada = new DateTime();
		$ad  = $ada->setTimestamp( time() );

		$ada = new DateTime();
		$tt  = (time() + (HOUR_IN_SECONDS * 2));
		$ad  = $ada->setTimestamp( $tt );


		echo '<br><br>';
		echo $da->format( 'm/d/y H:i:s' );
		echo '<br><br>';
		echo $ada->format( 'm/d/y H:i:s' );

		$da->format( 'm/d/y H:i:s' );







//
//		echo ($aa * (30 * HOUR_IN_SECONDS));
//
//		echo $t->format($t,'d.m.Y H:i:s');
//		$dd = date('d.m.Y H:i:s');
//
//		$d = date('H:i:s');
//
//		echo $t;
//		echo $d;
		//$key             = ( $opt['key2'] !== '' ) ? $opt['key2'] : 'stalin';
		$settings_fields = [

			'wcb_links'    => [


			]
			,
			'wcb_settings' => [

				[
					'name'  => 'key2',
					'label' => __( 'Secret Key', 'wedevs' ),
					'desc'  => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'  => 'text',
					//	'default' => $key,
					//'sanitize_callback' => 'intval',
				],

				[
					'name'    => 'radio',
					'label'   => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'desc'    => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],

				[
					'name'    => 'email',
					'label'   => __( 'Set emails to get update notifications', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'text',
					'default' => 'andrewmgunn26@gmail.com',
					//'sanitize_callback' => 'intval',
				],
				[
					'name'    => 'ip',
					'label'   => __( 'Show IP', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'event',
					'label'   => __( 'event', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						$this->get_n(-1)=> $this->get_n(-1),
						$this->get_n(.25) => $this->get_n(.25),

						$this->get_n(.55)=> $this->get_n(.55),
						$this->get_n(1) => $this->get_n(1),

						$this->get_n(1.25)=> $this->get_n(1.25),
						$this->get_n(1.4) => $this->get_n(1.4),


					],
				],
				[
					'name'    => 'css',
					'label'   => __( 'CSS', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'html',
					'label'   => __( 'HTML', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],


			],


			'wcb_styles'   => [

			]
			,

		];

		return $settings_fields;
	}

	function admin_menu() {

		echo '';
		add_options_page( 'Iron Curtain', 'Iron Curtain', 'manage_options', 'wp-irc-admin', [
			$this,
			'plugin_page',
		] );
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
