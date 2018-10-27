<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */

namespace Netraa\IRC;

class Settings {

	private $settings_api;

	function __construct() {

		$this->settings_api = new \Netraa\IRC\SettingsAPI();

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
				'id'    => 'irc_settings',
				'title' => __( 'Settings', 'wedevs' ),
			],
			[
				'id'    => 'irc_config',
				'title' => __( 'Config', 'wedevs' ),
			],
			[
				'id'    => 'irc_data',
				'title' => __( 'Data', 'wedevs' ),
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

		$settings_fields = [
			'irc_settings' => [

				[
					'name'    => 'key',
					'label'   => __( 'Secret Key', 'wedevs' ),
					'desc'    => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'    => 'text',
					'default' => 'stalin',
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
			],
			'irc_config'   => [
				[
					'name'    => 'notify',
					'label'   => __( 'Notify status change', 'wedevs' ),
					'desc'    => __( 'Email current status when changed', 'wedevs' ),
					'type'    => 'radio',
					'default' => '',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'              => 'email',
					'label'             => __( 'Sent to email', 'wedevs' ),
					'desc'              => __( 'Seperated by comma', 'wedevs' ),
					'type'              => 'text',
					'default'           => 'rwasser63@gmail.com,andrewmgunn26@gmail.com',
				],
				[
					'name'    => 'activetaxs',
					'label'   => __( 'Taxonomy', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'default' => '',

					'options' => [
						'Part Category' => 'Item Category',
						'Part Tag'      => 'Item Tag',
						'Vendor'        => 'Vendor',
						'Location'      => 'Location',
						'Req Type'      => 'Req Type',
					],
				],
				[
					'name'    => 'wysiwyg',
					'label'   => __( 'Advanced Editor', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'ajaxid',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'default' => '5666',
					'options' => [
						//json_encode( $arr )
						'5637' => '5637',
						'5667' => '5667',
					],
				],
				[
					'name'    => 'select2',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select2',
					'default' => '',
					'options' => [

					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
			],

			'irc_data' => [],


		];

		return $settings_fields;
	}

	function admin_menu() {

		add_menu_page( 'IRC', 'IRC', 'manage_options', 'wp-irc', [
			$this,
			'plugin_page',
		], 'dashicons-upload', 62 );
	}

	function plugin_page() {

		echo '<div class="wrap">';
		echo '<h1>WP Iron Curtain</h1>';
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
