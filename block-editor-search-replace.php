<?php
/**
 * Plugin Name: Block Editor Search & Replace
 * Plugin URI: https://krasenslavov.com/
 * Description: Effortlessly search and replace text within the Block Editor's content area, with full support for the Classic Editor.
 * Version: 1.2.0
 * Author: Krasen Slavov
 * Author URI: https://developry.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: block-editor-search-replace
 * Domain Path: /lang
 *
 * Copyright (c) 2018 - 2024 Developry Ltd. (email: contact@developry.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace DEVRY\BESNR;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

define( __NAMESPACE__ . '\BESNR_ENV', 'prod' ); // prod, dev

define( __NAMESPACE__ . '\BESNR_MIN_PHP_VERSION', '7.2' );
define( __NAMESPACE__ . '\BESNR_MIN_WP_VERSION', '5.0' );

define( __NAMESPACE__ . '\BESNR_PLUGIN_UUID', 'besnr' );
define( __NAMESPACE__ . '\BESNR_PLUGIN_TEXTDOMAIN', 'block-editor-search-replace' );
define( __NAMESPACE__ . '\BESNR_PLUGIN_NAME', esc_html__( 'Block Editor Search & Replace', 'block-editor-search-replace' ) );
define( __NAMESPACE__ . '\BESNR_PLUGIN_VERSION', '1.2.0' );
define( __NAMESPACE__ . '\BESNR_PLUGIN_DOMAIN', 'developry.com' );
define( __NAMESPACE__ . '\BESNR_PLUGIN_DOCS', 'https://krasenslavov.com/plugins/block-editor-search-replace' );

define( __NAMESPACE__ . '\BESNR_PLUGIN_WPORG_SUPPORT', 'https://wordpress.org/support/plugin/block-editor-search-replace/#new-topic' );
define( __NAMESPACE__ . '\BESNR_PLUGIN_WPORG_RATE', 'https://wordpress.org/support/plugin/block-editor-search-replace/reviews/#new-post' );

define( __NAMESPACE__ . '\BESNR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( __NAMESPACE__ . '\BESNR_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\BESNR_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

define(
	__NAMESPACE__ . '\BESNR_PLUGIN_ALLOWED_HTML_ARR',
	wp_json_encode(
		array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'name'   => array(),
			),
			'option' => array(
				'value'    => array(),
				'selected' => array(),
			),
		)
	)
);

// URL for dev/prod for image folder.
if ( 'dev' === BESNR_ENV ) {
	define( __NAMESPACE__ . '\BESNR_PLUGIN_IMG_URL', BESNR_PLUGIN_DIR_URL . 'assets/dev/images/' );
} else {
	define( __NAMESPACE__ . '\BESNR_PLUGIN_IMG_URL', BESNR_PLUGIN_DIR_URL . 'assets/dist/img/' );
}

require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/admin.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/library/class-besnr-admin.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/library/class-block-editor-search-replace.php';
