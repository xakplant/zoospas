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
function zs_print_pet_card(){

    // Wraper start
    do_action('zs_card_wraper_start');

    // Title
    do_action('zs_card_title');

    // Excerpt
    do_action('zs_card_excerpt');

    // Meta
    do_action('zs_card_meta');

    // Thumb
    do_action('zs_card_thumbnail');

    // Content
     do_action('zs_card_content');

     // Admin Edit
    do_action('zs_admin_edit_post');

    // Wraper end
    do_action('zs_card_wraper_end');

}

add_action('zs_print_pet_card', 'zs_print_pet_card', 10);
add_shortcode('zs_print_pet_card', 'zs_print_pet_card');

function zs_card_wraper_start(){
    echo '<div class="zs_card">';
}
add_action('zs_card_wraper_start', 'zs_card_wraper_start', 20);

function zs_card_wraper_end(){
    echo '</div>';
}
add_action('zs_card_wraper_end', 'zs_card_wraper_end', 20);


function zs_card_title(){

    the_title('<h2>', '</h2>');

}
add_action('zs_card_title', 'zs_card_title', 20);

function zs_card_excerpt(){

    the_excerpt();

}
add_action('zs_card_excerpt', 'zs_card_excerpt', 20);

function zs_card_thumbnail(){

    echo '<img src="' .get_the_post_thumbnail_url() . '"/>';

}
add_action('zs_card_thumbnail', 'zs_card_thumbnail', 20);

function zs_card_content(){

    the_content();

}
add_action('zs_card_content', 'zs_card_content', 20);


function zs_card_meta(){

    $arrKeys = ZoospasFilter::zs_get_meta_key();

    $result = [];

    foreach ($arrKeys as $key){

        $result += [$key => get_post_custom_values( $key, $post->ID )];

    }

    $table_setting = [
        'class'=>['table', 'table-default'],
        'id'=>'zs_meta_table',
        'data-type'=>'zs_meta_table'
    ];

    ob_start();

    /**
     * @hook zs_attr_printer
     */
    do_action('zs_table_attr', $table_setting);

    $output = ob_get_contents();

    ob_end_clean();

    echo '<table '.$output.'>';
    echo '<tbody>';

    foreach ($result as $key=>$value){

        echo '<tr><td>' . __(substr($key, 4), 'zoospas') . '</td><td>'.$value[0].'</td></tr>';

    }
    echo '</tbody>';
    echo '</table>';


}
add_action('zs_card_meta', 'zs_card_meta', 20);

/**
 * @param $settings
 * print string with attr element
 */
function zs_attr_printer($settings){

    $attrs = '';

    foreach ($settings as $key=>$value){

        $attrs .= $key . '="';

        if(is_array($value)){

            foreach ($value as $val){

                $attrs .= $val.' ';

            }

        }
        elseif (is_string($value)){

            $attrs .= $value;

        }

        $attrs .= '" ';
    }

    echo $attrs;

}
add_action('zs_table_attr', 'zs_attr_printer');


function zs_admin_edit_post($settings = null){

    if(is_admin()){
        if($settings){

            echo '<a ';
            zs_attr_printer($settings);
            echo 'href="/wp-admin/post.php?post='. get_the_ID() .'&amp;action=edit">'.__('Edit', 'zoospas') .'</a>';;
        }
        else {

            echo '<a href="/wp-admin/post.php?post='. get_the_ID() .'&amp;action=edit">'.__('Edit', 'zoospas') .'</a>';

        }
    }
}
add_action('zs_admin_edit_post', 'zs_admin_edit_post');



/**
 * Meta key alias
 */
function zs_get_meta_key_alias(){
    return [
        '_zs_age'=> __('Age', 'zoospas'),
        '_zs_sex'=> __('Sex', 'zoospas'),
        '_zs_size'=> __('Size', 'zoospas'),
        '_zs_pet_type'=> __('Type of pets', 'zoospas'),
    ];
}
