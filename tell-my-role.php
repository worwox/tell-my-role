<?php
/**
 * Plugin Name:     Tell My Role
 * Plugin URI:      https://WPCouple.com
 * Description:     A plugin to display user roles in WordPress dashboard.
 * Version:         1.0.0
 * Author:          WPCouple
 * Author URI:      https://WPCouple.com
 * Contributors:    WPCouple, mrasharirfan
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     tell-my-role
 *
 * @package tell-my-role
 */

/**
 * Tell My Role.
 *
 * Get the roles of current user and display it.
 *
 * @since 1.0.0
 */
function tmr_display_current_user_role() {
	// Get current user.
	$current_user = wp_get_current_user();

	// Get the user roles.
	$current_user_roles = $current_user->roles;

	// Convert user roles array into a string.
	$current_user_roles = implode( ', ', $current_user_roles );

	// Get `tmr_setting` setting.
	$tmr_setting = get_option( 'tmr_setting', false );

	// Display user roles.
	echo '<p class="tmr_user_roles tmr_user_roles__head">' . esc_html( $tmr_setting . ' ' . $current_user_roles ) . '</p>';
}

// Hook it!
add_action( 'admin_notices', 'tmr_display_current_user_role' );

/**
 * Style the Display.
 *
 * This method styles the user roles.
 *
 * @since 1.0.0
 */
function tmr_style_display() {
	?>
	<style>
		.tmr_user_roles {
			display: inline-block;
			text-transform: uppercase;
		}

		.tmr_user_roles__head {
			background: #0085ba;
			color: #ffffff;
			padding: 5px 10px;
		}
	</style>
	<?php
}

// Hook it!
add_action( 'admin_head', 'tmr_style_display' );

/**
 * Settings Init.
 *
 * Initialize settings for the plugin.
 *
 * @since 1.0.0
 */
function tmr_settings_init() {
	// Register a new section in the "tmr-options-page" page.
	add_settings_section(
		'tmr_settings_section', // Section ID.
		'Tell My Role Settings', // Section Title.
		'tmr_settings_section_callback', // Section callback function.
		'tmr-options-page' // Slug of the admin page.
	);

	// Register a new field in the "tmr_settings_section" section, inside the "tmr-options-page" page.
	add_settings_field(
		'tmr_setting_field', // Setting ID.
		'Setting Title', // Setting Title
		'tmr_settings_field_callback', // Setting callback function.
		'tmr-options-page', // Slug of the admin page.
		'tmr_settings_section' // Setting section ID.
	);

	// Register a new setting.
	register_setting( 'tmr_settings_group', 'tmr_setting' );
}

// Register tmr_settings_init to the admin_init action hook.
add_action( 'admin_init', 'tmr_settings_init' );

/**
 * Section Content Callback.
 */
function tmr_settings_section_callback() {
	echo '<p>Plugin Settings Section</p>';
}

/**
 * Setting Field Content Callback.
 */
function tmr_settings_field_callback() {
	// Get the value of the setting we've registered with register_setting().
	$setting = get_option( 'tmr_setting' );

	// Output the field.
	?>
	<input type="text" id="tmr_setting" name="tmr_setting" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
	<?php
}

/**
 * TMR Settings Page.
 *
 * Add settings page to WP dashboard menu.
 *
 * @since 1.0.0
 */
function tmr_options_page() {
	// Add top level menu page.
	add_menu_page(
		'Tell My Role Settings',
		'TMR Options',
		'manage_options',
		'tmr-options-page',
		'tmr_options_page_html',
		'dashicons-admin-generic',
		90
	);
}

// Register our `tmr_options_page` to the `admin_menu` action hook.
add_action( 'admin_menu', 'tmr_options_page' );

/**
 * TMR Settings Page Content.
 *
 * Callback function for TMR menu page.
 *
 * @since 1.0.0
 */
function tmr_options_page_html() {
	// Check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>" method="post">
			<?php
			// Output security fields for the registered setting `tmr_settings_group`.
			settings_fields( 'tmr_settings_group' );

			// Output setting sections and their fields.
			do_settings_sections( 'tmr-options-page' );

			// Output save settings button.
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}
