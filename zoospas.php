<?php
/**
 * @package Zoospas
 */
/*
Plugin Name: Zoospas
Plugin URI: https://web.799000.ru/
Description: Доска объявлений бездомных животных .Плагин создан при поддержке <a href="https://te-st.ru">Теплицы социальных технологий</a>.
Version: 0.1.2
Author: ANIT
Author URI: https://799000.ru/
License: GPLv2 or later
Contributors:
	Boris Cherepanov (cherr_guw@mail.com)
	Teplitsa Support Team (suptestru@gmail.com)
Text Domain: zoospas
*/



if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

load_plugin_textdomain('zoospas', false, basename( dirname( __FILE__ ) ) . '/languages' );

define( 'ZOOSPAS_VERSION', '0.1.2' );
define( 'ZOOSPAS_FRONTEND_VERSION', WP_DEBUG ? date("YmdHis") . rand() : '2.4' );
define( 'ZOOSPAS_MINIMUM_WP_VERSION', '0.1' );
define( 'ZOOSPAS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('ZOOSPAS_PLUGIN_URL', plugin_dir_url(__FILE__));
define( 'ZOOSPAS_DELETE_LIMIT', 100000 );


register_activation_hook( __FILE__, array( 'Zoospas', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Zoospas', 'plugin_deactivation' ) );


require_once ( ZOOSPAS_PLUGIN_DIR . '/admin-pages/functions.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/admin-pages/events.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/front-pages/functions.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/front-pages/events.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/front-pages/events-single-page.php' );
require_once ( ZOOSPAS_PLUGIN_DIR . '/assets/functions.php' );



require_once( ZOOSPAS_PLUGIN_DIR . '/classes/Zoospas.php' );
require_once( ZOOSPAS_PLUGIN_DIR . '/classes/ZoospasVars.php' );
new ZoospasVars();

require_once( ZOOSPAS_PLUGIN_DIR . '/classes/ZoospasFilter.php' );

require_once( ZOOSPAS_PLUGIN_DIR . '/classes/ZoospasForm.php' );



add_action( 'init', array( 'Zoospas', 'init' ) );

register_activation_hook( __FILE__, array( 'Zoospas', 'plugin_activation' ) );
register_deactivation_hook(__FILE__, array( 'Zoospas', 'plugin_deactivation' ) );
register_uninstall_hook(__FILE__, array('Zoospas', 'plugin_uninstall'));


add_action('admin_menu', array( 'Zoospas', 'menu_item' ));
add_action('admin_menu', array( 'Zoospas', 'zs_options' ));

__('Pet type', 'zoospas');
