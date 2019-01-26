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

require_once ( ZOOSPAS_PLUGIN_DIR . '/admin-pages/fieldset.php' );



add_action('init', 'zoospas_register_post_types');

function zoospas_register_post_types(){
    register_post_type('zs_pets', array(
        'label'  => 'Pets',
        'labels' => array(
            'singular_name'      => __('Pet', 'zoospas'), // название для одной записи этого типа
            'name'               => __('Pets', 'zoospas'), // основное название для типа записи
            'add_new'            => __('Add Pet', 'zoospas'), // для добавления новой записи
            'add_new_item'       => __('Addition Pet', 'zoospas'), // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => __('Edit Pet', 'zoospas'), // для редактирования типа записи
            'new_item'           => __('New Pet', 'zoospas'), // текст новой записи
            'view_item'          => __('View Pet', 'zoospas'), // для просмотра записи этого типа.
            'search_items'       => __('Search Pet', 'zoospas'), // для поиска по этим типам записи
            'not_found'          => __('Pets no found', 'zoospas'), // если в результате поиска ничего не было найдено
            'not_found_in_trash' => __('Pets no found in trash', 'zoospas'), // если не было найдено в корзине
            'parent_item_colon'  => __('Parent of Pets', 'zoospas'), // для родителей (у древовидных типов)
            'menu_name'          => __('Pets', 'zoospas') // название меню
        ),
        'description'         => 'Описание записей с животными',
        'public'              => true,
        'publicly_queryable'  => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui'             => null, // зависит от public
        'show_in_menu'        => 'zs_admin', // показывать ли в меню адмнки
        'show_in_admin_bar'   => true, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => true, // зависит от public
        'show_in_rest'        => false, // добавить в REST API. C WP 4.7
        'rest_base'           => false, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'query_var'           => true,
        'supports' => array(
                'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
        ),
        'rewrite' => array('slug' => 'pets'),
    ) );
}

