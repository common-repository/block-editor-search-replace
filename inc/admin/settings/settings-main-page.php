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

$besnr_admin = new BESNR_Admin();

$has_user_cap = $besnr_admin->check_user_cap();

?>
<div class="besnr-admin">
	<div class="besnr-loading-bar"></div>
	<div id="besnr-output" class="notice is-dismissible besnr-output"></div>
	<?php settings_errors( 'besnr_settings_errors' ); ?>

	<h2>
		<?php echo esc_html__( 'Block Editor Search & Replace', 'block-editor-search-replace' ); ?>
	</h2>

	<p>
		<?php
		printf(
			wp_kses(
				__( 'Effortlessly search and replace text within the Block Editor\'s content area, with full support for the Classic Editor.', 'block-editor-search-replace' ),
				json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
			),
		);
		?>
	</p>

	<hr />

	<form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>">
		<?php wp_nonce_field( 'besnr_settings_nonce', 'besnr_wpnonce' ); ?>
		<?php
			settings_fields( BESNR_SETTINGS_SLUG );
			do_settings_sections( BESNR_SETTINGS_SLUG );
		?>
		<p class="submit button-group">
			<button
				type="submit"
				class="button button-primary"
				id="submit-button"
				name="submit-button"
			>
				<?php echo esc_html__( 'Save', 'block-editor-search-replace' ); ?>
			</button>
			<button
				type="button"
				class="button"
				id="besnr-reset-button"
				name="besnr-reset-button"
			>
				<?php echo esc_html__( 'Reset', 'block-editor-search-replace' ); ?>
			</button>
		</p>
	</form>

	<br clear="all" />

	<hr />

	<div class="besnr-support-credits">
		<p>
			<?php
			printf(
				wp_kses(
					/* translators: %1$s is replaced with "Link to WP.org support forums" */
					__( 'If something is not clear, please open a ticket on the official plugin %1$s. All tickets should be addressed within a couple of working days.', 'block-editor-search-replace' ),
					json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
				),
				'<a href="' . esc_url( BESNR_PLUGIN_WPORG_SUPPORT ) . '" target="_blank">' . esc_html__( 'Support Forum', 'block-editor-search-replace' ) . '</a>'
			);
			?>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Please rate us', 'block-editor-search-replace' ); ?></strong>
			<a href="<?php echo esc_url( BESNR_PLUGIN_WPORG_RATE ); ?>" target="_blank">
				<img src="<?php echo esc_url( BESNR_PLUGIN_DIR_URL ); ?>assets/dist/img/rate.png" alt="Rate us @ WordPress.org" />
			</a>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Having issues?', 'block-editor-search-replace' ); ?></strong> 
			<a href="<?php echo esc_url( BESNR_PLUGIN_WPORG_SUPPORT ); ?>" target="_blank">
				<?php echo esc_html__( 'Create a Support Ticket', 'block-editor-search-replace' ); ?>
			</a>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Developed by', 'block-editor-search-replace' ); ?></strong>
			<a href="https://krasenslavov.com/" target="_blank">
				<?php echo esc_html__( 'Krasen Slavov @ Developry', 'block-editor-search-replace' ); ?>
			</a>
		</p>
	</div>

	<hr />

	<p>
		<small>
			<?php
			printf(
				wp_kses(
					/* translators: %1$s is replaced with "Link to Patreon" */
					__( '* For the price of a cup of coffee per month, you can help and support me on %1$s in continuing to develop and maintain all of my free WordPress plugins, every little bit helps and is greatly appreciated!', 'block-editor-search-replace' ),
					json_decode( BESNR_PLUGIN_ALLOWED_HTML_ARR, true )
				),
				'<a href="https://patreon.com/krasenslavov" target="_blank">' . esc_html__( 'Patreon', 'block-editor-search-replace' ) . '</a>'
			);
			?>
		</small>
	</p>
</div>
