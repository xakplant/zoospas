<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 10.09.2018
 * Time: 11:21
 */
//todo переписать название шорткода
add_shortcode('zs_meta_array', 'zs_print_filter_n_results');

function zs_print_filter_n_results(){

    // Подключение скриптов и стилей
    do_action('zoospas_enqueue');


    // Печать фильтра из класса
    do_action('zs_print_filter_class');


    // Контейнер для вывода результатов по AJAX
    do_action('zs_result_filer_box');


}
add_action('zs_print_filter_class', array( 'ZoospasFilter', 'zs_print_filter' ));
add_action('zs_result_filer_box', array( 'ZoospasFilter', 'zs_print_result_box' ));
add_action( 'wp_enqueue_scripts', array( 'ZoospasFilter', 'zs_localize_script' ), 99 );
add_action('wp_footer',  array( 'ZoospasFilter', 'zs_filert_ajax_script' ), 99);
add_action('wp_ajax_zs_filtered', array( 'ZoospasFilter', 'zs_filter_handler' ));
add_action('wp_ajax_nopriv_zs_filtered', array( 'ZoospasFilter', 'zs_filter_handler' ));

