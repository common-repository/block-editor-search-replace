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
 * [AJAX] Reset all the options on the Options page to default values.
 */
function besnr_reset_options_default() {
	$besnr_admin = new BESNR_Admin();

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	delete_option( 'besnr_types_supported' );
	delete_option( 'besnr_editors_supported' );
	delete_option( 'besnr_full_text_support' );
	delete_option( 'besnr_compact_mode' );

	$besnr_admin->print_json_message(
		1,
		__( 'All options were reset to their default values.', 'block-editor-search-replace' )
	);
}

add_action( 'wp_ajax_besnr_reset_options_default', __NAMESPACE__ . '\besnr_reset_options_default' );
