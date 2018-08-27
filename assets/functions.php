<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25.08.2018
 * Time: 15:01
 */

add_action( 'admin_enqueue_scripts', 'zoospas_enqueue_css_js' );
function zoospas_enqueue_css_js($hook){
    if ( 'toplevel_page_zs_admin' == $hook || 'zoospas_page_zs_pet_list' == $hook ) {
        wp_enqueue_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');
        wp_enqueue_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/main.js', '', '1.0', true);
    }
}