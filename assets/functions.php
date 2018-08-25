<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25.08.2018
 * Time: 15:01
 */

function zoospas_front_register_css_js(){
    wp_register_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/main.js', '', '1.0', true);
    wp_register_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'zoospas_front_register_css_js');