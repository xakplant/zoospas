<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 11:46
 */


add_action('wp_footer', 'zs_get_bitrix_open_line', 100);
function zs_get_bitrix_open_line(){
    ?>

    <script data-skip-moving="true">
        (function(w,d,u){
            var s=d.createElement('script');s.async=1;s.src=u+'?'+(Date.now()/60000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn.bitrix24.ru/b7941911/crm/site_button/loader_4_jxb0l8.js');
    </script>

    <?php
}

add_action('init', 'zoospas_register_post_types');

function zoospas_register_post_types(){
    register_post_type('post_type_name', array(
        'label'  => 'Pets',
        'labels' => array(
            'singular_name'      => 'Pet', // название для одной записи этого типа
            'name'               => 'Pets', // основное название для типа записи
            'add_new'            => 'Add Pet', // для добавления новой записи
            'add_new_item'       => 'Addition Pet', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Pet', // для редактирования типа записи
            'new_item'           => 'New Pet', // текст новой записи
            'view_item'          => 'View Pet', // для просмотра записи этого типа.
            'search_items'       => 'Search Pet', // для поиска по этим типам записи
            // todo нормально перевести запись ниже
            'not_found'          => 'Pets no found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Pets no found in trash', // если не было найдено в корзине
            'parent_item_colon'  => 'Parent of Pets', // для родителей (у древовидных типов)
            'menu_name'          => 'Pets' // название меню
        ),
        'description'         => 'Описание записей с животными',
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
        'rewrite'             => true,
        'query_var'           => true,
    ) );
}