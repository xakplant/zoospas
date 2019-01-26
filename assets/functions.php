<?php
/**
 * @package Zoospas
 */
/*
Plugin Name: Zoospas project for Hakaton
Plugin URI: https://web.799000.ru/
Description: Доска объявлений бездомных животных .Плагин создан при поддержке <a href="https://te-st.ru">Теплицы социальных технологий</a>.
Version: 0.1.0
Author: ANIT
Author URI: https://799000.ru/
License: GPLv2 or later
Contributors:
	Boris Cherepanov (cherr_guw@mail.com)
	Teplitsa Support Team (suptestru@gmail.com)
Text Domain: zoospas
*/

add_action( 'admin_enqueue_scripts', 'zoospas_enqueue_css_js' );
function zoospas_enqueue_css_js($hook){
    if ( 'toplevel_page_zs_admin' == $hook || 'zoospas_page_zs_pet_list' == $hook ) {
        wp_enqueue_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/admin.css', array(), '1.0');
        wp_enqueue_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/admin.js', array(), '1.0', true);
    }
}

function zoospas_front_register_css_js() {

    wp_register_style('zoospas_style_front', ZOOSPAS_PLUGIN_URL . 'assets/css/front.css', array(), '2.0');
    wp_register_script('zoospas_front', ZOOSPAS_PLUGIN_URL . 'assets/js/front.js', array(), '1.0', true);
    wp_register_script('zoospas_modal', ZOOSPAS_PLUGIN_URL . 'assets/js/modal.js', array(), '1.0', true);
    wp_register_script('zoospas_handle', ZOOSPAS_PLUGIN_URL . 'assets/js/empty.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'zoospas_front_register_css_js' );

function zoospas_enqueue_front(){

    wp_enqueue_style('zoospas_style_front');
    wp_enqueue_script('zoospas_front');

}
add_action('zoospas_enqueue', 'zoospas_enqueue_front');

function zoospas_handle_script(){
    wp_enqueue_script('zoospas_handle');
}
add_action( 'wp_enqueue_scripts', 'zoospas_handle_script' );