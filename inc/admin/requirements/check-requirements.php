<?php
/**
 * [Short description]
 *
 * @package    DEVRY\BESNR
 * @copyright  Copyright (c) 2024, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since      1.1
 */

namespace DEVRY\BESNR;

! defined( ABSPATH ) || exit; // Exit if accessed directly

/**
 * Stop plugin activation if minimum requirement aren't met & display error notice.
 */
function besnr_check_requirements() {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( version_compare( PHP_VERSION, BESNR_MIN_PHP_VERSION ) >= 0
		&& version_compare( $GLOBALS['wp_version'], BESNR_MIN_WP_VERSION ) >= 0 ) {
		load_plugin_textdomain( BESNR_PLUGIN_TEXTDOMAIN, false, BESNR_PLUGIN_BASENAME . 'lang' );

		add_action(
			'plugin_action_links',
			__NAMESPACE__ . '\besnr_add_action_links',
			10,
			2
		);

		add_action(
			'admin_enqueue_scripts',
			__NAMESPACE__ . '\besnr_enqueue_admin_assets'
		);

		add_action(
			'enqueue_block_assets', // 'enqueue_block_editor_assets',
			__NAMESPACE__ . '\besnr_enqueue_block_editor_assets'
		);
	} else {
		$message = sprintf(
			wp_kses(
				/* translators: %1$s is replaced with "Plugin Name" */
				/* translators: %2$s is replaced with "Min PHP Version" */
				/* translators: %3$s is replaced with "Min WP Version" */
				__( '%1$s requires a minimum of PHP %2$s and WordPress %3$s', 'block-editor-search-replace' ),
				json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
			),
			'<strong>' . BESNR_PLUGIN_NAME . '</strong>',
			'<em>' . BESNR_MIN_PHP_VERSION . '</em>',
			'<em>' . BESNR_MIN_WP_VERSION . '</em>.<br />'
		);

		$message .= sprintf(
			wp_kses(
				/* translators: %1$s is replaced with "PHP Version" */
				/* translators: %2$s is replaced with "WordPress Version" */
				__( 'You are currently running PHP %1$s and WordPress %2$s.', 'block-editor-search-replace' ),
				json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
			),
			'<strong>' . PHP_VERSION . '</strong>',
			'<strong>' . $GLOBALS['wp_version'] . '</strong>'
		);

		printf(
			/* translators: %1$s is replaced with PHP and WordPress message check */
			'<div class="notice notice-error is-dismissible"><p>%1$s</p></div>',
			wp_kses( $message, json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true ) )
		);

		deactivate_plugins( BESNR_PLUGIN_BASENAME );
	}
}

add_action( 'admin_init', __NAMESPACE__ . '\besnr_check_requirements' );
