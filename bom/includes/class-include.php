<?php
/**
 * BOM Include.
 *
 * @since   0.0.0
 * @package BOM
 */

/**
 * BOM Include.
 *
 * @since 0.0.0
 */
class BOM_Include {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   BOM
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  BOM $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

	}
}
