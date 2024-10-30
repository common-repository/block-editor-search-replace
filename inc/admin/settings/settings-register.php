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
 * Register the Options form fields.
 */
function besnr_register_options_fields() {
	register_setting( BESNR_SETTINGS_SLUG, 'besnr_types_supported', __NAMESPACE__ . '\besnr_sanitize_types_supported' );
	register_setting( BESNR_SETTINGS_SLUG, 'besnr_editors_supported', __NAMESPACE__ . '\besnr_sanitize_editors_supported' );
	register_setting( BESNR_SETTINGS_SLUG, 'besnr_full_text_support', __NAMESPACE__ . '\besnr_sanitize_full_text_support' );
	register_setting( BESNR_SETTINGS_SLUG, 'besnr_compact_mode', __NAMESPACE__ . '\besnr_sanitize_compact_mode' );
}

add_action( 'admin_init', __NAMESPACE__ . '\besnr_register_options_fields' );
