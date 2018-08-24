<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 11:46
 */
function zoospas_register_css_js(){
    wp_register_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/main.js', '', '1.0', true);
    wp_register_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');
}
add_action('admin_enqueue_scripts ', 'zoospas_register_css_js');




