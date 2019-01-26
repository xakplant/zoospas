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


add_action('zs_filter_wrap_start', 'zs_filter_wrap_start', 10, 1);
function zs_filter_wrap_start($zs_attribute){
    echo '<div class="zs_filter_block"><form ' . $zs_attribute . '>';
}
add_action('zs_filter_select_wrap_start', 'zs_filter_select_wrap_start', 10, 1);
function zs_filter_select_wrap_start($key){
    echo '<div data-type="zs_filter"><label>' . __(substr($key, 4), 'zoospas') . '</label><br>';
}
add_action('zs_filter_select_wrap_end', 'zs_filter_select_wrap_end', 10);
function zs_filter_select_wrap_end(){
    echo '</div>';
}

add_action('zs_filter_print_button', 'zs_filter_print_button', 10, 1);
function zs_filter_print_button($zs_attribute){
    echo '<button type="submit" ' . $zs_attribute . ' class="btn-zs-default">' . __('Select', 'zoospas'). '</button>';
}

add_action('zs_filter_wrap_end', 'zs_filter_wrap_end', 10);
function zs_filter_wrap_end(){
    echo '</form></div>';
}


