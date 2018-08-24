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


    public static function init(){

        add_action( 'admin_enqueue_scripts', 'zoospas_register_css_js' );

    }

    public static function plugin_activation(){


/*
        CREATE TABLE IF NOT EXISTS animal (
                    id int NOT NULL AUTO_INCREMENT,
            sex tinyint,
            kind varchar(255),
            age varchar(255),
            breed varchar(255),
            preview varchar(255),
            PRIMARY KEY (id)
        );
        CREATE TABLE IF NOT EXISTS image (
                    id int NOT NULL AUTO_INCREMENT,
            src varchar(255),
            animal_id int,
            PRIMARY KEY (id),
            FOREIGN KEY (animal_id) REFERENCES animal(id)
        );
        CREATE TABLE IF NOT EXISTS activist (
                    id int NOT NULL AUTO_INCREMENT,
            name varchar(255),
            phone varchar(255),
            email varchar(255),
            PRIMARY KEY (id)
        );
        CREATE TABLE IF NOT EXISTS social (
                    id int NOT NULL AUTO_INCREMENT,
            reference varchar(255),
            activist_id int,
            PRIMARY KEY (id),
            FOREIGN KEY (activist_id) REFERENCES activist(id)
        );
        CREATE TABLE IF NOT EXISTS animal_activist (
                    animal_id int,
            activist_id int,
            date varchar(255),
            type_relationship tinyint,
            PRIMARY KEY (animal_id, activist_id),
            FOREIGN KEY (animal_id) REFERENCES animal(id),
            FOREIGN KEY (activist_id) REFERENCES activist(id)
        );*/

    }


    public static function plugin_deactivation(){


    }

    public static function menu_item(){

            add_menu_page( __( 'Zoospas', 'zoospas' ), __( 'Zoospas', 'zoospas' ), 'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));

            add_submenu_page( 'zs_admin', __( 'Admin Panel', 'zoospas' ) , __( 'Admin Panel', 'zoospas' ) ,   'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));

            add_submenu_page( 'zs_admin', __( 'Pet list', 'zoospas' ), __( 'Pet list', 'zoospas' ),  'manage_options', 'zs_pet_list', array( __CLASS__, 'pet_list' ));



    }

    public static function  admin_panel(){

        wp_enqueue_scripts('zoospas_style');

        echo '<h2>' . __( 'Admin Panel', 'zoospas' ) . '</h2>';

        do_action('zs_general_content_of_pages_before_content');

        do_action('zs_admin_panel');

        do_action('zs_general_content_of_pages_after_content');


    }

    public static function pet_list(){


        echo '<h2>' . __( 'Pet list', 'zoospas' ) . '</h2>';

        do_action('zs_general_content_of_pages_before_content');

        do_action('zs_pet_list');

        do_action('zs_general_content_of_pages_after_content');


    }



}