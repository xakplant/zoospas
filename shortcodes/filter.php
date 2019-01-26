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
add_shortcode('zs_print_filter', 'zs_print_filter_n_results');
add_action('zs_print_filter', 'zs_print_filter_n_results');
function zs_print_filter_n_results(){


    wp_add_inline_script('zoospas_handle', ZoospasFilter::zs_filert_ajax_script_string(), 'after' );
    // Подключение скриптов и стилей
    do_action('zoospas_enqueue');

    // Печать фильтра из класса
    do_action('zs_print_filter_class');

    // Контейнер для вывода результатов по AJAX
    do_action('zs_result_filer_box');

}
add_action('zs_print_filter_class', array( 'ZoospasFilter', 'zs_print_filter' ));
add_action('zs_result_filer_box', array( 'ZoospasFilter', 'zs_print_result_box' ), 10);
add_action( 'wp_enqueue_scripts', array( 'ZoospasFilter', 'zs_localize_script' ), 99 );

add_action('wp_ajax_zs_filtered', array( 'ZoospasFilter', 'zs_filter_handler' ));
add_action('wp_ajax_nopriv_zs_filtered', array( 'ZoospasFilter', 'zs_filter_handler' ));




