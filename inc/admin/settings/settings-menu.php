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
 * Add the block editor search & replace page to the admin menu.
 */
function besnr_add_menu() {
	$besnr = new Block_Editor_Search_Replace();

	if ( '' === $besnr->compact_mode ) {
		add_menu_page(
			esc_html__( 'Block Editor Search & Replace', 'block-editor-search-replace' ),
			esc_html__( 'Search & Replace', 'block-editor-search-replace' ),
			'manage_options',
			BESNR_SETTINGS_SLUG,
			__NAMESPACE__ . '\besnr_display_page',
			'dashicons-search'
		);
	} else {
		add_submenu_page(
			'options-general.php',
			esc_html__( 'Block Editor Search & Replace', 'block-editor-search-replace' ),
			esc_html__( 'Search & Replace', 'block-editor-search-replace' ),
			'manage_options',
			BESNR_SETTINGS_SLUG,
			__NAMESPACE__ . '\besnr_display_page'
		);
	}
}

add_action( 'admin_menu', __NAMESPACE__ . '\besnr_add_menu', 1000 );
