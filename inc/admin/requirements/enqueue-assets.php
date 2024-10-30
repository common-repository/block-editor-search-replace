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

! defined( ABSPATH ) || exit; // Exit if accessed directly.

/**
 * Enqueue admin assets below.
 */
function besnr_enqueue_admin_assets() {
	if ( ! is_admin() ) {
		return;
	}

	// Load assets only for page page staring with prefix besnr-.
	// $screen = get_current_screen();
	// if ( strpos( $screen->id, 'besnr_' ) ) {}

	wp_enqueue_style(
		'besnr-admin',
		BESNR_PLUGIN_DIR_URL . 'assets/dist/css/besnr-admin.min.css',
		array(),
		BESNR_PLUGIN_VERSION,
		'all'
	);

	wp_enqueue_script(
		'besnr-admin',
		BESNR_PLUGIN_DIR_URL . 'assets/dist/js/besnr-admin.min.js',
		array( 'jquery' ),
		BESNR_PLUGIN_VERSION,
		true
	);

	wp_localize_script(
		'besnr-admin',
		'besnr',
		array(
			'plugin_url'    => BESNR_PLUGIN_DIR_URL,
			'plugin_domain' => BESNR_PLUGIN_DOMAIN,
			'ajax_url'      => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajax_nonce'    => wp_create_nonce( 'besnr_ajax_nonce' ),
		)
	);
}

/**
 * Enqueue block editor assets below.
 */
function besnr_enqueue_block_editor_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_style(
		'besnr-block-editor',
		BESNR_PLUGIN_DIR_URL . 'assets/dist/css/besnr-block-editor.min.css',
		array(),
		BESNR_PLUGIN_VERSION,
		'all'
	);

	wp_enqueue_script(
		'besnr-block-editor',
		BESNR_PLUGIN_DIR_URL . 'assets/dist/js/besnr-block-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-plugins', 'wp-edit-post', 'wp-data' ), // Dependencies.
		BESNR_PLUGIN_VERSION,
		true
	);

	wp_localize_script(
		'besnr-block-editor',
		'besnr',
		array(
			'plugin_url'    => BESNR_PLUGIN_DIR_URL,
			'plugin_domain' => BESNR_PLUGIN_DOMAIN,
			'ajax_url'      => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajax_nonce'    => wp_create_nonce( 'besnr_ajax_nonce' ),
		)
	);
}
