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

    }

    public static function pet_list(){

        echo '<h2>' . __( 'Pet list', 'zoospas' ) . '</h2>';

        do_action('zs_general_content_of_pages_before_content');

        do_action('zs_pet_list');

        do_action('zs_general_content_of_pages_after_content');


    }



}