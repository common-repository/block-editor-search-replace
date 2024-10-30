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

// The slug for plugin main page.
define( __NAMESPACE__ . '\BESNR_SETTINGS_SLUG', 'besnr_settings' );

require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-menu.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-page.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-actions.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-register.php';

require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/editors-supported.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/types-supported.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/full-text-support.php';
require_once BESNR_PLUGIN_DIR_PATH . 'inc/admin/settings/compact-mode.php';
