<?php
/**
 * @package Zoospas
 */



class Zoospas
{


    public static function init(){
        require_once ( ZOOSPAS_PLUGIN_DIR . '/shortcodes/functions.php' );
        flush_rewrite_rules();
    }


    public static function plugin_activation(){

    }


    public static function plugin_deactivation(){

    }

    public static function plugin_uninstall(){

    }



    public static function menu_item(){

        add_menu_page( __( 'Zoospas', 'zoospas' ), __( 'Zoospas', 'zoospas' ), 'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));

        global $submenu;
        $url = '/wp-admin/post-new.php?post_type=zs_pets';
        $submenu['zs_admin'][] = array(__('Add pet', 'zoospas'), 'manage_options', $url);

        add_submenu_page( 'zs_admin', __( 'Admin Panel', 'zoospas' ) , __( 'Admin Panel', 'zoospas' ) ,   'manage_options', 'zs_admin', array( __CLASS__, 'admin_panel' ));
        add_submenu_page( 'zs_admin', __( 'Support', 'zoospas' ) , __( 'Support', 'zoospas' ) ,   'manage_options', 'zs_support', array( __CLASS__, 'support' ));

    }

    public static function  support(){

        ?>
        <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>
        <a href="https://github.com/xakplant/zoospas" target="_blank"><?php echo __('Documentation', 'zoospas'); ?></a>
        </div>

        <?php
    }

    public static function  admin_panel(){
        ?>

        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>


            <form action="options.php" method="POST">
                <?php
                settings_fields( 'zs_option_group' );
                do_settings_sections( 'zs_options' );
                submit_button();
                ?>
            </form>
            <form action="options.php" method="POST">
                <?php
                settings_fields( 'zs_option_group2' );
                do_settings_sections( 'zs_options_two' );
                submit_button();
                ?>
            </form>
        </div>

        <?php
    }

    public static function zs_options(){

        add_settings_section('zs_option_group', __('Настройки целевых кнопок', 'zoospas'), 'zs_display_options_group', 'zs_options');
        add_settings_section('zs_option_group2', __('Настройки формы обратной связи', 'zoospas'), 'zs_display_options_group', 'zs_options_two');
        /**
         * Настройки кнопок
         */

        add_settings_field('zs_left_button_text', __('Left button text', 'zoospas'), function (){
            echo '<input type="input" name="zs_left_button_text" id="zs_left_button_text" value="'. get_option('zs_left_button_text') .'" />';
        }, 'zs_options', 'zs_option_group');
        
        add_settings_field('zs_left_button_class', __('Left button class', 'zoospas'), function (){
            echo '<input type="input" name="zs_left_button_class" id="zs_left_button_class" value="'. get_option('zs_left_button_class') .'" />';
        }, 'zs_options', 'zs_option_group');

        add_settings_field('zs_left_button_link', __('Left button link', 'zoospas'), function (){
            echo '<input type="input" name="zs_left_button_link" id="zs_left_button_link" value="'. get_option('zs_left_button_link') .'" />';
        }, 'zs_options', 'zs_option_group');

        add_settings_field('zs_left_button_html_id', __('Left button html id', 'zoospas'), function (){
            echo '<input type="input" name="zs_left_button_html_id" id="zs_left_button_html_id" value="'. get_option('zs_left_button_html_id') .'" />';
            echo '<hr/>';
        }, 'zs_options', 'zs_option_group');


        add_settings_field('zs_right_button_text', __('Right button text', 'zoospas'), function (){
            echo '<input type="input" name="zs_right_button_text" id="zs_right_button_text" value="'. get_option('zs_right_button_text') .'" />';
        }, 'zs_options', 'zs_option_group');

        add_settings_field('zs_right_button_class', __('Right button class', 'zoospas'), function (){
            echo '<input type="input" name="zs_right_button_class" id="zs_right_button_class" value="'. get_option('zs_right_button_class') .'" />';
        }, 'zs_options', 'zs_option_group');

        add_settings_field('zs_right_button_link', __('Right button link', 'zoospas'), function (){
            echo '<input type="input" name="zs_right_button_link" id="zs_right_button_link" value="'. get_option('zs_right_button_link') .'" />';
        }, 'zs_options', 'zs_option_group');

        add_settings_field('zs_right_button_html_id', __('Right button html id', 'zoospas'), function (){
            echo '<input type="input" name="zs_right_button_html_id" id="zs_right_button_html_id" value="'. get_option('zs_right_button_html_id') .'" />';
        }, 'zs_options', 'zs_option_group');


        /**
         * Настройки первой кнопки
         */
        register_setting('zs_option_group', 'zs_left_button_text');
        register_setting('zs_option_group', 'zs_left_button_class');
        register_setting('zs_option_group', 'zs_left_button_link');
        register_setting('zs_option_group', 'zs_left_button_html_id');

        /**
         * Настройки второй кнопки
         */
        register_setting('zs_option_group', 'zs_right_button_text');
        register_setting('zs_option_group', 'zs_right_button_class');
        register_setting('zs_option_group', 'zs_right_button_link');
        register_setting('zs_option_group', 'zs_right_button_html_id');


        /**
         * Настройки второй формы обратной связи
         */
        add_settings_field('zs_form_email', __('Email for form', 'zoospas'), function (){
            echo '<input type="email" name="zs_form_email" id="zs_form_email" value="'. get_option('zs_form_email') .'" />';
        }, 'zs_options_two', 'zs_option_group2');

        add_settings_field('zs_form_type', __('Type', 'zoospas'), function (){

            $type = ['js', 'link', 'modal', 'form'];
            $value = get_option('zs_form_type');
            ?>

            <select id="zs_right_button_html_id" name="zs_form_type">
                <?php foreach ($type as $t):?>
                    <option value="<?php echo $t ?>" <?php echo ($t == $value) ? 'selected' : ''; ?> ><?php echo __($t, 'zoospas'); ?></option>
                <?php endforeach; ?>
            </select>

            <?php

        }, 'zs_options_two', 'zs_option_group2');

        add_settings_field('zs_form_class', __('Form html class', 'zoospas'), function (){
            echo '<input type="text" name="zs_form_class" id="zs_form_class" value="'. get_option('zs_form_class') .'" />';
        }, 'zs_options_two', 'zs_option_group2');


        add_settings_field('zs_form_btn_text', __('Button text', 'zoospas'), function (){
            echo '<input type="input" name="zs_form_btn_text" id="zs_form_btn_text" value="'. get_option('zs_form_btn_text') .'" />';
        }, 'zs_options_two', 'zs_option_group2');


        add_settings_field('zs_form_btn_class', __('Button class', 'zoospas'), function (){
            echo '<input type="input" name="zs_form_btn_class" id="zs_form_btn_class" value="'. get_option('zs_form_btn_class') .'" />';
        }, 'zs_options_two', 'zs_option_group2');

        add_settings_field('zs_form_btn_html_id', __('Button html id', 'zoospas'), function (){
            echo '<input type="input" name="zs_form_btn_html_id" id="zs_form_btn_html_id" value="'. get_option('zs_form_btn_html_id') .'" />';
        }, 'zs_options_two', 'zs_option_group2');

        add_settings_field('zs_form_btn_link', __('Button link', 'zoospas'), function (){
            echo '<input type="input" name="zs_form_btn_link" id="zs_form_btn_link" value="'. get_option('zs_form_btn_link') .'" />';
        }, 'zs_options_two', 'zs_option_group2');


        add_settings_field('zs_form_btn_js', __('JS', 'zoospas'), function (){
            echo '<textarea name="zs_form_btn_js" id="zs_form_btn_js">' . get_option('zs_form_btn_js') . '</textarea>';
        }, 'zs_options_two', 'zs_option_group2');

        register_setting('zs_option_group2', 'zs_form_email');
        register_setting('zs_option_group2', 'zs_form_type');
        register_setting('zs_option_group2', 'zs_form_class');
        register_setting('zs_option_group2', 'zs_form_btn_text');
        register_setting('zs_option_group2', 'zs_form_btn_js');
        register_setting('zs_option_group2', 'zs_form_btn_class');
        register_setting('zs_option_group2', 'zs_form_btn_link');
        register_setting('zs_option_group2', 'zs_form_btn_html_id');

    }


}