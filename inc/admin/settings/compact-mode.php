<?php
/**
 * [Short description]
 *
 * @package    DEVRY\BESNR
 * @copyright  Copyright (c) 2024, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since      1.4
 */

namespace DEVRY\BESNR;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

/**
 * Display the compact mode option.
 */
function besnr_display_compact_mode() {
	$besnr = new Block_Editor_Search_Replace();

	$compact_mode = get_option( 'besnr_compact_mode', $besnr->compact_mode );

	// No if empty or non-existent, otherwise select Yes.
	if ( 'yes' === $compact_mode ) {
		$compact_mode = 'selected';
	}

	printf(
		'<select id="besnr-compact-mode" name="besnr_compact_mode">
			<option value="">No</option>
			<option value="yes" %1$s>Yes</option>
		</select>',
		esc_attr( $compact_mode )
	);
	?>
		<p class="description">
			<small>
				<?php echo esc_html__( 'Enable compact mode and move the plugin main link to sub menu.', 'block-editor-search-replace' ); ?>
			</small>
		</p>
	<?php
}

/**
 * Sanitize and update compact mode option.
 */
function besnr_sanitize_compact_mode( $compact_mode ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['besnr_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['besnr_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'besnr_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $compact_mode ) ) {
		return;
	}

	// Option changed and updated.
	if ( get_option( 'besnr_compact_mode' ) !== $compact_mode ) {
		add_settings_error(
			'besnr_settings_errors',
			'besnr_compact_mode',
			esc_html__( 'Compact mode option was updated successfully.', 'block-editor-search-replace' ),
			'updated'
		);
	}

	return sanitize_text_field( $compact_mode );
}
