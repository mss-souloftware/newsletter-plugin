<?php
/**
 * Plugin Name: Form Submissions
 * plugin URI: https://souloftware.com/
 * Description: A simple form submission plugin with AJAX and database storage.
 * Version: 1.0
 * Author: Souloftware
 * Author URI: https://souloftware.com/contact
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// Define plugin path
define('NEWSLETTER_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Include necessary files
require_once NEWSLETTER_PLUGIN_DIR . 'includes/database.php';
require_once NEWSLETTER_PLUGIN_DIR . 'includes/shortcode.php';
require_once NEWSLETTER_PLUGIN_DIR . 'includes/ajax-handler.php';
require_once NEWSLETTER_PLUGIN_DIR . 'includes/admin-page.php';

// Activation Hook - Create Database Table
register_activation_hook(__FILE__, 'custom_plugin_activate');
