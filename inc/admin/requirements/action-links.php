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
 * Add settings link after plugin activation under Plugins.
 */
function besnr_add_action_links( $links, $file_path ) {
	if ( BESNR_PLUGIN_BASENAME === $file_path ) {
		$besnr = new Block_Editor_Search_Replace();

		$admin_page = ( '' === $besnr->compact_mode )
			? 'admin.php?page=besnr_settings'
			: 'options-general.php?page=besnr_settings';

		$links['besnr-settings'] = '<a href="' . esc_url( admin_url( $admin_page ) ) . '">'
			. esc_html__( 'Settings', 'block-editor-search-replace' )
			. '</a>';
		$links['besnr-upgrade']  = '<a href="https://bit.ly/3vljBDo" target="_blank">'
			. esc_html__( 'Go Pro', 'block-editor-search-replace' )
			. '</a>';

		return array_reverse( $links );
	}

	return $links;
}
