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

class ZoospasVars
{
    public static $options;

    public function __construct()
    {
        self::$options = self::get_options_array();
    }

    public static function get_options_array(){
        return [
            'buttons'=>[
                'left' => [
                    'text'=> get_option('zs_left_button_text'),
                    'class'=> get_option('zs_left_button_class'),
                    'url'=> get_option('zs_left_button_link'),
                    'html_id'=> get_option('zs_left_button_html_id'),
                ],
                'right' => [
                    'text'=> get_option('zs_right_button_text'),
                    'class'=> get_option('zs_right_button_class'),
                    'url'=> get_option('zs_right_button_link'),
                    'html_id'=> get_option('zs_right_button_html_id'),
                ],

            ],
            'form'=>[
                'email'=>get_option('zs_form_email'),
                'type'=>get_option('zs_form_type'),
                'form_class'=>get_option('zs_form_class'),
                'text'=>get_option('zs_form_btn_text'),
                'js'=>get_option('zs_form_btn_js'),
                'class'=>get_option('zs_form_btn_class'),
                'link'=>get_option('zs_form_btn_link'),
                'html_id'=>get_option('zs_form_btn_html_id'),
                'action'=>'zoospas_form'
            ]
        ];
    }

}