<?php
if (!defined('ABSPATH')) {
    exit;
}

function custom_plugin_activate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $newsletter_table = $wpdb->prefix . 'newsletter_subscribers';
    $contact_table = $wpdb->prefix . 'contact_form_submissions';

    $sql = "CREATE TABLE $newsletter_table (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;

    CREATE TABLE $contact_table (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

