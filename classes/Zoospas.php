<?php

/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 10:43
 */

use Cb\Admin\Tables;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}



class Zoospas
{


    private static $table_options = 'zs_options';
    private static $table_activists = 'zs_activists';
    private static $table_activists_soclink = 'zs_activists_soclink';
    private static $table_pets = 'zs_pets';
    private static $table_pet_meta = 'zs_pet_meta';
    private static $table_pet_pics = 'zs_pet_image';


    public static function init(){

        require_once ( ZOOSPAS_PLUGIN_DIR . '/shortcodes/functions.php' );

    }

    public static function plugin_activation(){

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $table  = $wpdb->prefix . self::$table_activists;


        /**
         * Таблица с данными активиста
         */



        $sql = 'CREATE TABLE IF NOT EXISTS '. $table .' (
          id int NOT NULL AUTO_INCREMENT,
            name varchar(255),
            phone varchar(255),
            email varchar(255),
            PRIMARY KEY (id)
        )' . $charset_collate;

        dbDelta( $sql );

        /**
         * Таблица со ссылками на соц. сети активиста
         */

        $table  = $wpdb->prefix . self::$table_activists_soclink;

        $sql = 'CREATE TABLE IF NOT EXISTS '. $table .' (
          id int NOT NULL AUTO_INCREMENT,
            reference varchar(255),
            activist_id int,
            PRIMARY KEY (id),
            FOREIGN KEY (activist_id) REFERENCES '. $wpdb->prefix . self::$table_activists .'(id)
        )' . $charset_collate;

        dbDelta( $sql );


        /**
         * Таблица с фотографиями животных (для слайдшоу)
         */


        $table  = $wpdb->prefix . self::$table_pet_pics;

        $sql = 'CREATE TABLE IF NOT EXISTS '. $table .' (
            id int NOT NULL AUTO_INCREMENT,
            src varchar(255),
            animal_id int,
            PRIMARY KEY (id),
            FOREIGN KEY (animal_id) REFERENCES '. $wpdb->prefix . self::$table_pets .'(id)
        )' . $charset_collate;

        dbDelta( $sql );


    }


    public static function plugin_deactivation(){






    }

    public static function plugin_uninstall(){

        global $wpdb;


        /**
         * Удаление таблицы с волонтёроами
         */

        $table = $wpdb->prefix . self::$table_activists;

        $sql = 'DROP TABLE '. $table;

        $wpdb->query($sql);


        /**
         * Удаление таблицы соц.сетей волонтёров
         */

        $table = $wpdb->prefix . self::$table_activists_soclink;

        $sql = 'DROP TABLE '. $table;

        $wpdb->query($sql);

        /**
         * Удаление таблицы с фотографиями животных (для слайдшоу)
         */


        $table = $wpdb->prefix . self::$table_pet_pics;

        $sql = 'DROP TABLE '. $table;

        $wpdb->query($sql);



    }



    public static function menu_item(){

        add_menu_page( __( 'Zoospas', 'zoospas' ), __( 'Zoospas', 'zoospas' ), 'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));

        add_submenu_page( 'zs_admin', __( 'Admin Panel', 'zoospas' ) , __( 'Admin Panel', 'zoospas' ) ,   'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));

        add_submenu_page( 'zs_admin', __( 'Pet list', 'zoospas' ), __( 'Pet list', 'zoospas' ),  'manage_options', 'zs_pet_list', array( __CLASS__, 'pet_list' ));

    }

    public static function  admin_panel(){


        echo '<h2>' . __( 'Admin Panel', 'zoospas' ) . '</h2>';


        do_action('zs_general_content_of_pages_before_content');

        do_action('zs_admin_panel');

        do_action('zs_general_content_of_pages_after_content');

        do_action('admin_enqueue_scripts');


    }

    public static function pet_list(){


        echo '<h2>' . __( 'Pet list', 'zoospas' ) . '</h2>';

        /*$screen = get_current_screen();

        echo '<pre>';
        print_r($screen);
        echo '</pre>';*/


        do_action('zs_general_content_of_pages_before_content');

        do_action('zs_pet_list');

        do_action('zs_general_content_of_pages_after_content');


    }



}