<?php
/**
 * Plugin Name: Digicells Flight Booking Pro
 * Plugin URI: https://digicellinternational.github.io
 * Description: Professional flight booking system with search form, autocomplete airports, traveler selection, cabin class, and contact form popup. Sends booking requests to admin and assigned flight agents.
 * Version: 1.0.0
 * Author: Sardar Ali Khamosh (Digicells)
 * Text Domain: digicells-fbp
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DCFB_VERSION', '1.0.0');
define('DCFB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DCFB_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once DCFB_PLUGIN_DIR . 'includes/class-dcfb-activator.php';
require_once DCFB_PLUGIN_DIR . 'includes/class-dcfb-admin.php';
require_once DCFB_PLUGIN_DIR . 'includes/class-dcfb-frontend.php';
require_once DCFB_PLUGIN_DIR . 'includes/class-dcfb-ajax.php';
require_once DCFB_PLUGIN_DIR . 'includes/airports-data.php';

// Activation hook
register_activation_hook(__FILE__, array('DCFB_Activator', 'activate'));

// Initialize admin
if (is_admin()) {
    new DCFB_Admin();
}

// Initialize frontend
new DCFB_Frontend();

// Initialize AJAX handlers
new DCFB_Ajax();