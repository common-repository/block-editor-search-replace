<?php
/**
 * [Short Description]
 *
 * @package    DEVRY\BESNR
 * @copyright  Copyright (c) 2024, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since      1.1
 */

namespace DEVRY\BESNR;


! defined( ABSPATH ) || exit; // Exit if accessed directly.

if ( ! class_exists( 'Block_Editor_Search_Replace' ) ) {

	class Block_Editor_Search_Replace {
		/**
		 * Add search and replace types supported.
		 */
		public $types_supported;

		/**
		 * Add editors support, classic and/or block.
		 */
		public $editors_supported;

		/**
		 * Add full-text support for search and replace.
		 */
		public $full_text_support;

		/**
		 * Add compact mode for search and replace.
		 */
		public $compact_mode;

		/**
		 * Consturtor.
		 */
		public function __construct() {
			// Use some defaults for the Options, for initial plugin usage.
			$this->types_supported   = array( 'post', 'page' );
			$this->editors_supported = array( 'classic', 'block' );
			$this->full_text_support = ''; // No
			$this->compact_mode      = ''; // No

			// Retrieve from options, if available; otherwise, use the default values.
			$this->types_supported   = get_option( 'besnr_types_supported', $this->types_supported );
			$this->editors_supported = get_option( 'besnr_editors_supported', $this->editors_supported );
			$this->full_text_support = get_option( 'besnr_full_text_support', $this->full_text_support );
			$this->compact_mode      = get_option( 'besnr_compact_mode', $this->compact_mode );
		}

		/**
		 * Initializor.
		 */
		public function init() {
			add_action( 'wp_loaded', array( $this, 'on_loaded' ) );
		}

		/**
		 * Plugin loaded.
		 */
		public function on_loaded() {
			add_filter( 'add_meta_boxes', array( $this, 'add_classic_editor_support' ) );
		}

		/**
		 * Update post content with new after search and replace action.
		 */
		public function update_post_content( $post, $new_content ) {
			if ( is_a( $post, 'WP_Post' ) ) {
				// Temporarily remove the post revision saving filter
				remove_filter( 'post_updated', 'wp_save_post_revision' );

				// Convert to HTML entities for non-ASCII characters.
				$new_content = mb_encode_numericentity(
					$new_content,
					array( 0x80, 0x10FFFF, 0, 0x10FFFF ), // Define a conversion map for non-ASCII characters.
					'UTF-8'
				);

				// Update the post and check for errors
				$result = wp_update_post(
					array(
						'ID'           => $post->ID,
						'post_content' => preg_replace( '/\R/', '', $new_content ),
					),
					true
				);

				if ( is_wp_error( $result ) ) {
					return false;
				}

				// Re-add the post revision saving filter
				add_filter( 'post_updated', 'wp_save_post_revision' );

				return true;
			}

			return false;
		}

		/**
		 * Add Classic Editor search and replace meta box.
		 */
		public function add_classic_editor_support() {
			global $post;

			// Ensure that $post is a valid WP_Post object
			if ( ! isset( $post ) || ! is_a( $post, 'WP_Post' ) ) {
				return false;
			}

			// Create an array with enabled screens to show the Navigato Controls.
			$enabled_screens = array();

			// Get supported post types and editor support options
			$post_types = $this->types_supported;
			$editors    = $this->editors_supported;

			// Verify that the Classic Editor is active
			if ( ! $this->is_classic_editor_active() ) {
				return false;
			}

			// Check for Classic Editor via GET parameters
			if ( ! array_key_exists( 'classic-editor__forget', $_GET )
				|| ! array_key_exists( 'classic-editor', $_GET ) ) {
				return false;
			}

			// Available for Posts, Pages, WooCommerce Products & Custom Post Types.
			foreach ( $post_types as $post_type ) {
				array_push( $enabled_screens, $post_type );
			}

			// Check if the current post type is supported and Classic Editor is enabled
			if ( in_array( $post->post_type, $post_types, true )
				&& in_array( 'classic', $editors, true ) ) {
					add_meta_box(
						'classic_search_replace_metabox',
						esc_html__( 'Search & Replace', 'block-editor-search-replace' ), // Escaped and localized title
						array( $this, 'display_classic_editor_meta_box' ), // Callback function for the meta box
						$enabled_screens, // Screen where to add the meta box
						'side',           // Context where to add the meta box
						'high'            // Priority of the meta box
					);
			}
		}

		/**
		 * Display Classic Editor meta box.
		 */
		public function display_classic_editor_meta_box() {
			global $post;

			require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/views/classic-editor-meta-box.php';
		}

		/**
		 * Check if the Classic Editor is installed and active or not.
		 */
		public function is_classic_editor_active() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Retrieve all text nodes from a DOMDocument
		 */
		public function get_text_nodes( $node ) {
			$text_nodes = array();

			if ( XML_TEXT_NODE === $node->nodeType ) {
					$text_nodes[] = $node;
			} else {
				foreach ( $node->childNodes as $child_node ) {
					$text_nodes = array_merge( $text_nodes, $this->get_text_nodes( $child_node ) );
				}
			}

			return $text_nodes;
		}

		/**
		 * Extract the highlighted content from a DOMDocument.
		 */
		function get_highlighted_content( $dom ) {
			$content_highlighted = $dom->saveHTML();

			// Extract content between <body> tags.
			$start = strpos( $content_highlighted, '<body>' ) + 6;
			$end   = strpos( $content_highlighted, '</body>', $start );

			$content_highlighted = substr( $content_highlighted, $start, $end - $start );

			// Replace HTML-encoded tags with actual tags.
			$content_highlighted = str_replace( '&lt;besnr-highlight&gt;', '<besnr-highlight>', $content_highlighted );
			$content_highlighted = str_replace( '&lt;/besnr-highlight&gt;', '</besnr-highlight>', $content_highlighted );

			return $content_highlighted;
		}
	}

	$besnr = new Block_Editor_Search_Replace();
	$besnr->init();
}
