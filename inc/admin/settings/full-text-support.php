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
 * Display the full-text support option.
 */
function besnr_display_full_text_support() {
	$besnr = new Block_Editor_Search_Replace();

	$full_text_support = get_option( 'besnr_full_text_support', $besnr->full_text_support );

	// No if empty or non-existent, otherwise select Yes.
	if ( 'yes' === $full_text_support ) {
		$full_text_support = 'selected';
	}

	printf(
		'<select id="besnr-full-text-support" name="besnr_full_text_support">
			<option value="">No</option>
			<option value="yes" %1$s>Yes</option>
		</select>',
		esc_attr( $full_text_support )
	);
	?>
		<p class="description">
			<small>
				<?php echo esc_html__( 'Enable full-text support for the search and replace.', 'block-editor-search-replace' ); ?>
			</small>
		</p>
	<?php
}

/**
 * Sanitize and update the full-text support option.
 */
function besnr_sanitize_full_text_support( $full_text_support ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['besnr_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['besnr_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'besnr_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $full_text_support ) ) {
		return;
	}

	// Option changed and updated.
	if ( get_option( 'besnr_full_text_support' ) !== $full_text_support ) {
		add_settings_error(
			'besnr_settings_errors',
			'besnr_full_text_support',
			esc_html__( 'Full-text support option was updated successfully.', 'block-editor-search-replace' ),
			'updated'
		);

		return sanitize_text_field( $full_text_support );
	}
}
