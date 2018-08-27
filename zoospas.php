<?php
/**
 * @package Zoospas
 */
/*
Plugin Name: Zoospas project for Hakaton
Plugin URI: https://web.799000.ru/
Description:
Version: 0.1.0
Author: ANIT
Author URI: https://799000.ru/
License: GPLv2 or later
Text Domain: zoospas
*/



if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

define( 'ZOOSPAS_VERSION', '0.1.0' );
define( 'ZOOSPAS_MINIMUM_WP_VERSION', '0.1' );
define( 'ZOOSPAS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('ZOOSPAS_PLUGIN_URL', plugin_dir_url(__FILE__));
define( 'ZOOSPAS_DELETE_LIMIT', 100000 );


register_activation_hook( __FILE__, array( 'Zoospas', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Zoospas', 'plugin_deactivation' ) );


require_once ( ZOOSPAS_PLUGIN_DIR . '/admin-pages/functions.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/admin-pages/events.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/assets/functions.php' );
require_once( ZOOSPAS_PLUGIN_DIR . '/classes/Zoospas.php' );
require_once( ZOOSPAS_PLUGIN_DIR . '/classes/Pet_list_table.php' );

add_action( 'init', array( 'Zoospas', 'init' ) );

register_activation_hook( __FILE__, array( 'Zoospas', 'plugin_activation' ) );
register_deactivation_hook(__FILE__, array( 'Zoospas', 'plugin_deactivation' ) );
register_uninstall_hook(__FILE__, array(__CLASS__, 'plugin_uninstall'));


add_action('admin_menu', array( 'Zoospas', 'menu_item' ));
