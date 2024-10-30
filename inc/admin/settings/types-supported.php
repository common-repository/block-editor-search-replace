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
 * Display the types supported option.
 */
function besnr_display_types_supported() {
	$besnr = new Block_Editor_Search_Replace();

	$types_supported = get_option( 'besnr_types_supported', $besnr->types_supported );

	$options_html = '';

	$types_available = array(
		'post' => 'post',
		'page' => 'page',
	);

	foreach ( $types_available as $type ) {
		$type_text = ucwords( $type );
		$selected  = '';

		if ( in_array( $type, $types_supported, true ) ) {
			$selected = 'selected';
		}

		$options_html .= "<option value=\"{$type}\" {$selected}>{$type_text}</option>";
	}

	?>
		<select id="besnr-types-supported" name="besnr_types_supported[]" multiple>
			<?php echo wp_kses( $options_html, json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true ) ); ?>
		</select>
		<p class="description">
			<small>
				<?php echo esc_html__( 'Select supported types for the search and replace.', 'block-editor-search-replace' ); ?>
			</small>
		</p>
	<?php
}

/**
 * Sanitize and update types supported option.
 */
function besnr_sanitize_types_supported( $types_supported ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['besnr_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['besnr_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'besnr_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $types_supported ) ) {
		return;
	}

	// Option changed and updated.
	if ( get_option( 'besnr_types_supported' ) != $types_supported ) { // Don't use strict comparsions to check that arrays are equal.
		add_settings_error(
			'besnr_settings_errors',
			'besnr_types_supported',
			esc_html__( 'Supported types option was updated successfully.', 'block-editor-search-replace' ),
			'updated'
		);
	}

	return array_map( 'sanitize_text_field', $types_supported );
}
