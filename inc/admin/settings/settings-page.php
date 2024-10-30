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
 * Display the block editor search & replace page layout.
 */
function besnr_display_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	add_settings_section(
		BESNR_SETTINGS_SLUG,
		'Settings',
		'',
		BESNR_SETTINGS_SLUG
	);

	// Add setting field for editors supported.
	add_settings_field(
		'besnr_editors_supported',
		'<label for="besnr-editors-supported">'
			. esc_html__( 'Editors Supported', 'block-editor-search-replace' )
			. '</label>',
		__NAMESPACE__ . '\besnr_display_editors_supported',
		BESNR_SETTINGS_SLUG,
		BESNR_SETTINGS_SLUG,
	);

	// Add setting field for types supported.
	add_settings_field(
		'besnr_types_supported',
		'<label for="besnr-types-supported">'
			. esc_html__( 'Types Supported', 'block-editor-search-replace' )
			. '</label>',
		__NAMESPACE__ . '\besnr_display_types_supported',
		BESNR_SETTINGS_SLUG,
		BESNR_SETTINGS_SLUG,
	);

	// Add setting field for full-text support.
	add_settings_field(
		'besnr_full_text_support',
		'<label for="besnr-full-text-support">'
			. esc_html__( 'Full-text Support', 'block-editor-search-replace' )
			. '</label>',
		__NAMESPACE__ . '\besnr_display_full_text_support',
		BESNR_SETTINGS_SLUG,
		BESNR_SETTINGS_SLUG,
	);

	// Add setting field for compact mode.
	add_settings_field(
		'besnr_compact_mode',
		'<label for="besnr-compact-mode">'
			. esc_html__( 'Compact Mode', 'block-editor-search-replace' )
			. '</label>',
		__NAMESPACE__ . '\besnr_display_compact_mode',
		BESNR_SETTINGS_SLUG,
		BESNR_SETTINGS_SLUG,
	);

	require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-main-page.php';
}
