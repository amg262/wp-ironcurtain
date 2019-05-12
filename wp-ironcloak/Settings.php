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
				'id'    => 'cloak_data',
				'title' => __( 'Data', 'wedevs' ),
			],
			[
				'id'    => 'cloak_settings',
				'title' => __( 'Settings', 'wedevs' ),
			],
			[
				'id'    => 'cloak_styles',
				'title' => __( 'Styles', 'wedevs' ),
			],

		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		$opt = get_option( 'cloak_settings' );

		$settings_fields = [
			'cloak_data'     => [
				[
				],
			],
			'cloak_settings' => [
				[
					'name'    => 'key2',
					'label'   => __( 'Secret Key', 'wedevs' ),
					'desc'    => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'    => 'text',
					'default' => '',
					//'sanitize_callback' => 'intval',
				],

				[
					'name'    => 'radio',
					'label'   => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'desc'    => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'ip',
					'label'   => __( 'Show IP', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'select',
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
					'name'              => 'number_input2',
					'label'             => __( 'Minutes', 'wedevs' ),
					'desc'              => __( $this->get_n( ( $opt['number_input2'] / 60 ) ), 'wedevs' ),
					'type'              => 'text',
					'default'           => 60,
					'sanitize_callback' => '',
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						$this->get_n( ( $opt['number_input2'] / 60 ), 'H:i:s' ) => $this->get_n( ( $opt['number_input2'] / 60 ), 'H:i:s' ),
					],
				],

				[
					'name'    => 'color',
					'label'   => __( 'Color', 'wedevs' ),
					'desc'    => __( 'Color description', 'wedevs' ),
					'type'    => 'color',
					'default' => '',
				],
				[
					'name'    => 'color2',
					'label'   => __( 'Color', 'wedevs' ),
					'desc'    => __( 'Color description', 'wedevs' ),
					'type'    => 'color',
					'default' => '',
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
		];

		return $settings_fields;
	}

	function get_n( $int, $format = 'm/d/y h:i:s A' ) {

		$da = new DateTime();

		if ( $int === - 1 ) {
			$tt = time();
		} else {
			$tt = ( time() + ( HOUR_IN_SECONDS * $int ) );
		}

		$ad = $da->setTimestamp( $tt );
		echo $da->format( $format );


		return $da->format( $format );

	}


	function admin_menu() {

		echo '';
		add_options_page( 'Iron Curtain', 'Iron Curtain', 'manage_options', 'ironcloak-admin', [
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
