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
 * [AJAX] Highlight searched text on each keystroke.
 */
function besnr_highlight_search_text() {
	global $post;

	$besnr       = new Block_Editor_Search_Replace();
	$besnr_admin = new BESNR_Admin();

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	$current_post_id   = isset( $_REQUEST['current_post_id'] ) ? intval( sanitize_text_field( wp_unslash( $_REQUEST['current_post_id'] ) ) ) : 0;
	$search_phrase     = isset( $_REQUEST['search_phrase'] ) ? trim( sanitize_text_field( wp_unslash( $_REQUEST['search_phrase'] ) ) ) : '';
	$is_highlighted    = isset( $_REQUEST['is_highlighted'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_highlighted'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';
	$is_case_sensitive = isset( $_REQUEST['is_case_sensitive'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_case_sensitive'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';
	$is_classic_editor = isset( $_REQUEST['is_classic_editor'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_classic_editor'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';

	if ( ! $current_post_id ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Post ID not found!', 'block-editor-search-replace' )
		);
	}

	// Search and replace input cannot be empty.
	if ( empty( $search_phrase ) ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Cannot run search replace with empty search phrase!', 'block-editor-search-replace' )
		);
	}

	// Set minimum 3 characters before we start the search
	if ( strlen( $search_phrase ) < 3 ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Minimum 3 characters for your search text!', 'block-editor-search-replace' )
		);
	}

	$post         = get_post( $current_post_id );
	$post_content = apply_filters( 'the_content', $post->post_content );

	// Clean-up the custom tags before we highlight again.
	$content_cleaned = str_replace( array( '<besnr-highlight>', '</besnr-highlight>' ), array( '', '' ), $post_content );

	if ( ! $besnr->update_post_content( $post, $content_cleaned ) ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Unexpected error! Post content was not updated!', 'block-editor-search-replace' )
		);
	}

	if ( $is_highlighted ) {
		// Need to get again updated post_content after the clean-up.
		$post         = get_post( $current_post_id );
		$post_content = apply_filters( 'the_content', $post->post_content );

		$content_text_only = wp_strip_all_tags( $post_content );

		// Need to be able to cover both case-senstive and insensitive count, by default the function is case-sensitive.
		if ( $is_case_sensitive ) {
			$results_found = substr_count( $content_text_only, $search_phrase );
		} else {
			$results_found = substr_count( strtolower( $content_text_only ), strtolower( $search_phrase ) );
		}

		if ( $results_found > 0 ) {
			$dom = new \DOMDocument();

			libxml_use_internal_errors( true );
			$dom->loadHTML( $post_content );
			libxml_clear_errors();

			// Get all text nodes.
			$text_nodes = $besnr->get_text_nodes( $dom );

			// Iterate over text nodes and perform the replacement.
			foreach ( $text_nodes as $node ) {
				$content_text_node = $node->nodeValue;

				// Highlight text based on case sensitivity.
				if ( $is_case_sensitive ) {
					$content_text_modified = preg_replace(
						'~(?<!\w)' . stripslashes( $search_phrase ) . '(?!\w)~m',
						stripslashes( '<besnr-highlight>' . $search_phrase . '</besnr-highlight>' ),
						$content_text_node
					);
				} else {
					$replace_with_phrase_regex = '<besnr-highlight>$0</besnr-highlight>';

					// Highlight text case insensitively.
					$content_text_modified = preg_replace_callback(
						'~(?<!\w)' . stripslashes( $search_phrase ) . '(?!\w)~mi',
						function( $matches ) use ( $replace_with_phrase_regex ) {
							// Use $matches[0] to access the matched word.
							return preg_replace(
								'~\b' . stripslashes( $matches[0] ) . '\b~',
								$replace_with_phrase_regex,
								$matches[0]
							);
						},
						$content_text_node
					);
				}

				// Replace the content within the text node
				$node->nodeValue = $content_text_modified;
			}

			// Perform replacements
			$content_highlighted = $besnr->get_highlighted_content( $dom );

			if ( $besnr->update_post_content( $post, $content_highlighted ) ) {
				$besnr_admin->print_json_message(
					1,
					$results_found . ' results found for <strong>' . $search_phrase . '</strong>!'
				);
			}

			$besnr_admin->print_json_message(
				0,
				__( 'Unexpected error! Post content was not updated!', 'block-editor-search-replace' )
			);
		}

		$besnr_admin->print_json_message(
			0,
			__( 'No results found!', 'block-editor-search-replace' )
		);
	}
}

add_action( 'wp_ajax_besnr_highlight_search_text', __NAMESPACE__ . '\besnr_highlight_search_text' );

/**
 * [AJAX] Do the action search and replace and clean up the highlight tags.
 */
function besnr_do_search_and_replace() {
	global $post;

	$besnr       = new Block_Editor_Search_Replace();
	$besnr_admin = new BESNR_Admin();

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	$current_post_id     = isset( $_REQUEST['current_post_id'] ) ? intval( sanitize_text_field( wp_unslash( $_REQUEST['current_post_id'] ) ) ) : 0;
	$search_phrase       = isset( $_REQUEST['search_phrase'] ) ? trim( sanitize_text_field( wp_unslash( $_REQUEST['search_phrase'] ) ) ) : '';
	$replace_with_phrase = isset( $_REQUEST['replace_with_phrase'] ) ? trim( sanitize_text_field( wp_unslash( $_REQUEST['replace_with_phrase'] ) ) ) : '';
	$is_highlighted      = isset( $_REQUEST['is_highlighted'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_highlighted'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';
	$is_case_sensitive   = isset( $_REQUEST['is_case_sensitive'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_case_sensitive'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';
	$is_classic_editor   = isset( $_REQUEST['is_classic_editor'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_classic_editor'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';

	if ( ! $current_post_id ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Post ID not found!', 'block-editor-search-replace' )
		);
	}

	// Search and replace input cannot be empty.
	if ( empty( $search_phrase ) || empty( $replace_with_phrase ) ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Cannot run search replace with empty search or replace phrases!', 'block-editor-search-replace' )
		);
	}

	// Set minimum 3 characters before we start the search
	if ( strlen( $search_phrase ) < 3 ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Minimum 3 characters for your search text!', 'block-editor-search-replace' )
		);
	}

	// Set minimum 3 characters before we start the search
	if ( strlen( $replace_with_phrase ) < 3 ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Minimum 3 characters for your replace with text!', 'block-editor-search-replace' )
		);
	}

	$post         = get_post( $current_post_id );
	$post_content = apply_filters( 'the_content', $post->post_content );

	// Case sensitive
	if ( $is_case_sensitive ) {
		$content_new = str_replace( '<besnr-highlight>' . $search_phrase . '</besnr-highlight>', $replace_with_phrase, $post_content );
	} else {
		$content_new = str_ireplace( '<besnr-highlight>' . $search_phrase . '</besnr-highlight>', $replace_with_phrase, $post_content );
	}

	if ( $besnr->update_post_content( $post, $content_new ) ) {
		$besnr_admin->print_json_message(
			1,
			'<strong>' . $search_phrase . '</strong> replaced with <strong>' . $replace_with_phrase . '</strong> successfully!'
		);
	}

	$besnr_admin->print_json_message(
		0,
		__( 'Unexpected error! Post content was not updated!', 'block-editor-search-replace' )
	);
}

add_action( 'wp_ajax_besnr_do_search_and_replace', __NAMESPACE__ . '\besnr_do_search_and_replace' );

/**
 * [AJAX] Clean anre remove the custom tags used for highlighting.
 */
function besnr_clean_tags() {
	global $post;

	$besnr       = new Block_Editor_Search_Replace();
	$besnr_admin = new BESNR_Admin();

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	$current_post_id   = isset( $_REQUEST['current_post_id'] ) ? intval( sanitize_text_field( wp_unslash( $_REQUEST['current_post_id'] ) ) ) : 0;
	$is_classic_editor = isset( $_REQUEST['is_classic_editor'] ) ? filter_var( sanitize_text_field( wp_unslash( $_REQUEST['is_classic_editor'] ) ), FILTER_VALIDATE_BOOLEAN ) : '';

	if ( ! $current_post_id ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Post ID not found!', 'block-editor-search-replace' )
		);
	}

	$post         = get_post( $current_post_id );
	$post_content = apply_filters( 'the_content', $post->post_content );

	// Clean-up the custom highlight tags.
	$content_cleaned = str_replace( array( '<besnr-highlight>', '</besnr-highlight>' ), array( '', '' ), $post_content );

	if ( $besnr->update_post_content( $post, $content_cleaned ) ) {
		$besnr_admin->print_json_message(
			1,
			__( 'All custom tags were removed successfully!', 'block-editor-search-replace' )
		);
	}

	$besnr_admin->print_json_message(
		0,
		__( 'Unexpected error! Post content was not updated!', 'block-editor-search-replace' )
	);
}

add_action( 'wp_ajax_besnr_clean_tags', __NAMESPACE__ . '\besnr_clean_tags' );

/**
 * [AJAX] Update editor contents and reload with new contents.
 */
function besnr_update_editor_contents() {
	global $post;

	$besnr_admin = new BESNR_Admin();

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	$current_post_id = isset( $_REQUEST['current_post_id'] ) ? intval( sanitize_text_field( wp_unslash( $_REQUEST['current_post_id'] ) ) ) : 0;

	if ( ! $current_post_id ) {
		$besnr_admin->print_json_message(
			0,
			__( 'Post ID not found!', 'block-editor-search-replace' )
		);
	}

	$post         = get_post( $current_post_id );
	$post_content = apply_filters( 'the_content', $post->post_content );

	echo wp_json_encode(
		array(
			array(
				'status'  => 2,
				'message' => wp_json_encode( $post_content, JSON_UNESCAPED_UNICODE ),
			),
		)
	);

	exit;
}

add_action( 'wp_ajax_besnr_update_editor_contents', __NAMESPACE__ . '\besnr_update_editor_contents' );

/**
 * [AJAX] Get post content from the Block Editor reload.
 */
function besnr_get_post_content() {
	$besnr_admin = new BESNR_Admin();

	// Check for a valid post ID
	$current_post_id = isset( $_REQUEST['current_post_id'] ) ? intval( $_REQUEST['current_post_id'] ) : 0;

	$besnr_admin->get_invalid_nonce_token();
	$besnr_admin->get_invalid_user_cap();

	if ( ! $current_post_id ) {
		wp_send_json_error( 'Invalid post ID!' );
	}

	// Fetch the post content
	$post         = get_post( $current_post_id );
	$post_content = apply_filters( 'the_content', $post->post_content );

	if ( $post ) {
		wp_send_json_success( $post_content );
	} else {
		wp_send_json_error( 'Post not found.' );
	}
}

add_action( 'wp_ajax_besnr_get_post_content', __NAMESPACE__ . '\besnr_get_post_content' );
