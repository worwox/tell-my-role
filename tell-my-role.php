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

	// Display user roles.
	echo '<p class="tmr_user_roles tmr_user_roles__head">' . esc_html( $current_user_roles ) . '</p>';
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
