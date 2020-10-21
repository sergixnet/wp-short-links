<?php
/**
 * Plugin Name: Short Links
 * Plugin URI:  https://github.com/sergixnet/wp-short-links
 * Description: Plugin to create shortened url links.
 * Version:     1.0
 * Author:      Sergio Peña
 * Author URI:  https://github.com/sergixnet
 * Text Domain: short-links
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     Short Links
 * @author      Sergio Peña
 * @copyright   2020
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      sl
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

define( 'SL_MAIN_FILE', __FILE__ );

add_action( 'plugins_loaded', 'sl_plugin_init' );
/**
 * Load localization files
 *
 * @return void
 */
function sl_plugin_init() {
	load_plugin_textdomain( 'short-links', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Create custom post type shortlink.
require_once plugin_dir_path( __FILE__ ) . '/includes/cpt-short-links.php';

// Register metadata for the shortlink.
require_once plugin_dir_path( __FILE__ ) . '/includes/register-meta.php';

// Create custom metabox for the shortlink.
require_once plugin_dir_path( __FILE__ ) . '/includes/metaboxes.php';

// Handle redirections for the shortlink.
require_once plugin_dir_path( __FILE__ ) . '/includes/handle-redirects.php';

// Custon admin panel columns.
require_once plugin_dir_path( __FILE__ ) . '/includes/admin-columns.php';

// Load sample shortlinks.
require_once plugin_dir_path( __FILE__ ) . '/includes/sample-shortlinks.php';

// Register plugin activation hook and save sample shortlinks.
require_once plugin_dir_path( __FILE__ ) . '/includes/activate.php';

// Register new API routes to get shortlinks.
require_once plugin_dir_path( __FILE__ ) . '/includes/api-routes.php';
