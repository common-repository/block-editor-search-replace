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
 * Add plugin rating notice to get some feedback for users.
 */
function besnr_display_rating_notice() {
	if ( ! get_option( 'besnr_rating_notice', '' ) ) {
		$besnr = new Block_Editor_Search_Replace();

		$admin_page = ( '' === $besnr->compact_mode ) ? 'admin.php' : 'options-general.php';
		?>
			<div class="notice notice-info is-dismissible besnr-admin">
				<h3><?php echo esc_html( BESNR_PLUGIN_NAME ); ?></h3>
				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %1$s is replaced with by giving it 5 stars rating */
							__( '✨💪🔌 Could you please kindly help the plugin in your turn %1$s? (Thank you in advance)', 'block-editor-search-replace' ),
							json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
						),
						'<strong>' . esc_html__( 'by giving it 5 stars rating', 'block-editor-search-replace' ) . '</strong>'
					);
					?>
				</p>
				<div class="button-group">
					<a href="<?php echo esc_url( BESNR_PLUGIN_WPORG_RATE ); ?>" target="_blank" class="button button-primary">
						<?php echo esc_html__( 'Rate us @ WordPress.org', 'block-editor-search-replace' ); ?>
						<i class="dashicons dashicons-external"></i>
					</a>
					<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'besnr_settings', 'action' => 'besnr_dismiss_rating_notice', '_wpnonce' => wp_create_nonce( 'besnr_rating_notice_nonce' ) ), admin_url( $admin_page ) ) ); ?>" class="button">
						<?php echo esc_html__( 'I already did', 'block-editor-search-replace' ); ?>
					</a>
					<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'besnr_settings', 'action' => 'besnr_dismiss_rating_notice', '_wpnonce' => wp_create_nonce( 'besnr_rating_notice_nonce' ) ), admin_url( $admin_page ) ) ); ?>" class="button">
						<?php echo esc_html__( "Don't show this notice again!", 'block-editor-search-replace' ); ?>
					</a>
				</div>
			</div>
		<?php
	}
}

add_action( 'admin_notices', __NAMESPACE__ . '\besnr_display_rating_notice' );
