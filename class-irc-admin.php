<?php
/**
 * Created by PhpStorm.
 * User: SYSTEM
 * Date: 9/12/2018
 * Time: 2:13 AM
 */

class IRC_Admin {


	public $irc_settings;

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );

	}


	public function add_menu_page() {

		add_submenu_page( 'tools.php', 'Iron Curtain', 'Iron Curtain', 'manage_options', 'wp-iron-curtain', [
			$this,
			'create_menu_page',
		] );

	}

	/**
	 *
	 */
	public function create_menu_page() {

		$this->irc_settings = get_option( 'irc_settings' ); ?>

        <div class="irc-wrap wrap">
            <h1></h1>
            <form method="post" action="options.php">
				<?php

				settings_fields( 'irc_settings_group' );
				do_settings_sections( 'irc-admin' );
				//submit_button('Save All Options');
				?>
            </form>
        </div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		//global $geo_mashup_options;
		register_setting( 'irc_settings_group', // Option group
			'irc_settings', // Option name
			[ $this, 'sanitize' ] // Sanitize
		);

		add_settings_section( 'irc_settings_section', // ID
			'IRC Section', // Title
			[ $this, 'plugin_info' ], // Callback
			'irc-admin' // Page
		);

		add_settings_section( 'irc_admin', // ID
			'IRC Admin', // Title
			[ $this, 'irc_settings_page' ], // Callback
			'irc-admin', // Page
			'irc_settings_section' // Section
		);

	}


	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {

		$new_input = [];
		if ( isset( $input['irc_settings'] ) ) {
			$new_input['irc_settings'] = absint( $input['irc_settings'] );
		}

		return $input;
	}


	/**
	 *
	 */
	public function plugin_info() {

	    var_dump(get_option('irc_settings'));
	}
	/**
	 * Print the Section text
	 */

	/**
	 * Get the settings option array and print one of its values
	 */
	public function irc_settings_page() {
		//wp_enqueue_media();
		$irc_settings = (array) get_option( 'irc_settings' ); ?>

        <div id="irc-settings" class="irc-settings plugin-info header">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        Database
                    </th>
                    <td>
                        <fieldset><?php $key = 'update'; ?>
                            <input class="button button-primary" id='irc_settings[<?php echo $key; ?>]'
                                   name="irc_settings[<?php echo $key; ?>]" type="submit" value="Update Tags"/>
                        </fieldset>
                    </td>
                </tr>
                <tr><?php $label = 'Related';
					$key         = strtolower( $label );
					$id          = $key;
					?>
                    <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
                    <td>
                        <input type="text"
                               title="<?php _e( $id ); ?>"
                               id="<?php _e( $id ); ?>"
                               name="irc_settings[<?php _e( $key ); ?>]"
                               value="<?php echo $irc_settings[ $key ]; ?>"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        Plugin Scripts
                    </th>
                    <td>
                        <fieldset><?php $key = 'disable_clientside_script'; ?>

                            <label for="irc_settings[<?php echo $key; ?>]">Label</label>

                            <input id='irc_settings[<?php echo $key; ?>]' name="irc_settings[<?php echo $key; ?>]"
                                   type="checkbox" value="1" <?php checked( 1, $irc_settings[ $key ], true ); ?> />

                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th> <?php submit_button( 'Save Settings' ); ?></th>
                </tr>
                </tbody>
            </table>
        </div>
	<?php }


}