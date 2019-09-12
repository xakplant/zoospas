<?php
/**
 * @package Zoospas
 */


add_action( 'admin_enqueue_scripts', 'zoospas_enqueue_css_js' );
function zoospas_enqueue_css_js($hook){
    if ( 'toplevel_page_zs_admin' == $hook || 'zoospas_page_zs_pet_list' == $hook ) {
        wp_enqueue_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/admin.css', array(), ZOOSPAS_FRONTEND_VERSION);
        wp_enqueue_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/admin.js', array(), ZOOSPAS_FRONTEND_VERSION, true);
    }
}

function zoospas_front_register_css_js() {
    
    wp_register_style('zoospas_style_front', ZOOSPAS_PLUGIN_URL . 'assets/css/front.css', array(), ZOOSPAS_FRONTEND_VERSION);
    wp_register_style('zoospas_style_front_webflow_design', ZOOSPAS_PLUGIN_URL . 'assets/css/front-webflow.css', array(), ZOOSPAS_FRONTEND_VERSION);
    wp_register_script('zoospas_front', ZOOSPAS_PLUGIN_URL . 'assets/js/front.js', array('jquery'), ZOOSPAS_FRONTEND_VERSION, true);
    wp_register_script('zoospas_modal', ZOOSPAS_PLUGIN_URL . 'assets/js/modal.js', array('zoospas_front'), ZOOSPAS_FRONTEND_VERSION, true);
    wp_register_script('zoospas_handle', ZOOSPAS_PLUGIN_URL . 'assets/js/empty.js', array(), ZOOSPAS_FRONTEND_VERSION, true);
    //wp_register_script('zoospas_webflow', ZOOSPAS_PLUGIN_URL . 'assets/js/webflow.js', array('jquery'), ZOOSPAS_FRONTEND_VERSION, true);
    
}
add_action( 'wp_enqueue_scripts', 'zoospas_front_register_css_js' );

function zoospas_enqueue_front(){

    wp_enqueue_style('zoospas_style_front');
    wp_enqueue_style('zoospas_style_front_webflow_design');
    wp_enqueue_script('zoospas_front');
    //wp_enqueue_script('zoospas_webflow');
    
}
add_action('zoospas_enqueue', 'zoospas_enqueue_front');

function zoospas_handle_front(){
    if(get_post_type() == "zs_pets"){
        do_action('zoospas_enqueue');
    }
}
add_action( 'wp_enqueue_scripts', 'zoospas_handle_front' );

function zoospas_handle_script(){
    wp_enqueue_script('zoospas_handle');
}
add_action( 'wp_enqueue_scripts', 'zoospas_handle_script' );

function zoospas_inline_styles_for_teplitsa_plugins() {
    ?>
    <style>
        :root {
            --zoospas-color-main:  #18b6cd;
            --zoospas-main-dark:   #00c4e0;
            --zoospas-main-light:  #d1f4fa;
        }
    </style>
    <?php 
}
add_action('wp_head', 'zoospas_inline_styles_for_teplitsa_plugins', 11);