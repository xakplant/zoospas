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

class ZoospasForm
{
    public static $options;
    public static $email;
    public static $type;
    public static $form_class;
    public static $text;
    public static $js;
    public static $class;
    public static $link;
    public static $html_id;
    public static $subjects;
    public static $action;

    public function __construct()
    {
        self::$options = ZoospasVars::$options['form'];
        self::$email = self::$options['email'];
        self::$type = self::$options['type'];
        self::$form_class = self::$options['form_class'];
        self::$text = self::$options['text'];
        self::$js = self::$options['js'];
        self::$link = self::$options['link'];
        self::$class = self::$options['class'];
        self::$html_id = self::$options['html_id'];

        self::$action = self::$options['action'];

        self::$subjects = ['Shelter the animal', 'Financial help', 'Volunteer'];
    }

    public static function create_link(){
        $text = self::$text;
        $class = self::$class;
        $link = self::$link;
        $id = self::$html_id;

        return '<a href="' . $link . '" class="' . $class . '" id="' . $id . '">' . $text . '</a>';
    }

    public static function crete_js_text(){
        $js = self::$js;
        return $js;
    }

    public static function create_form(){
        $subjects = self::$subjects;
        $form_class = self::$form_class;
        $class_btn = self::$class;
        $action = self::$action;
        $form = '';

        if($_GET['zs_mail_responce'] == 'true'){
            echo '<p class="zs_nail_responce_box true zoospas_mb">'. __('Email send', 'zoospas') . '</p>';
        } elseif ($_GET['zs_mail_responce'] == 'false'){
            echo '<p class="zs_nail_responce_box false">'. __('Email not send', 'zoospas') . '</p>';
        }

        $form .= '<form class="' . $form_class . '" action="' . esc_url( admin_url('admin-post.php') ) . '" method="post">';
        $form .= '<input type="hidden" name="action" value="' . $action . '">';
        $form .= '<select name="subject" id="subject ">';
        foreach ($subjects as $subject){
            $form .= '<option>' . __($subject, 'zoospas') . '</option>';
        }
        $form .= '</select>';
        $form .= '<input type="email" name="email" placeholder="' . __('Add Email', 'zoospas') . '"/>';
        $form .= '<input type="tel" name="tel" required placeholder="' . __('Add Phone', 'zoospas') . '" />';

        $form .= '<button class="' . $class_btn . '" type="submit">'. __('send', 'zoospas') .'</button>';
        $form .= '</form>';

        return $form;
    }

    public static function creare_modal(){
        $text = self::$text;
        $class = self::$class;
        $id = self::$html_id;

        $modal = '';

        $modal .= '<a  class="' . $class . '" id="' . $id . '">' . $text . '</a>';

        return $modal;

    }

    public static function create_modal_inline_script(){
        $id = self::$html_id;
        $script = '';

        $script .= 'new XMC({';
        $script .= 'selector: "id",';
        $script .= 'selectorValue: \''. $id .'\',';
        $script .= "content: '" . self::create_form() . "',";
        $script .= 'bodyID: "zoospasModalBodyID" ,';
        $script .= 'backgroundLayerID: "zoospasModalBgID" ,';

        $script .= 'classListBody: ["zoospas_modal_body"],';
        $script .= 'classListBg: ["zoospas_modal_bg"],';
        $script .= 'classListBtn: ["zoospas_btn"],';

        $script .= "styleBg: {
        top: '0',
        left:'0',
        right: '0',
        bottom: '0',
        position: 'fixed',
        background: '#00000090',
        justifyContent: 'center',
        alignItems: 'center',
        zIndex: '9999'
    },
    styleBody: {
        minWidth: '200px',
        minHeight: '200px',
        background: '#ffffff',
        justifyContent: 'center',
        alignItems: 'center',
    },
    btnStyle: {
        width: '40px',
        height: \"40px\",
        background: '#ffffff',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        position: 'absolute',
        top: '5%',
        right: '5%',
        cursor: 'pointer'
    }";

        $script .= '});';

        return $script;

    }

    public static function get_value(){
        $value = '';

        if(self::$type == 'js'){
            $value = self::crete_js_text();
        }
        if(self::$type == 'link'){
            $value = self::create_link();
        }
        if(self::$type == 'form'){
            $value = self::create_form();
        }
        if(self::$type == 'modal'){

            if(self::$type == 'modal'){
                wp_enqueue_script('zoospas_modal');
                wp_add_inline_script('zoospas_modal', ZoospasForm::create_modal_inline_script(), 'after' );
            }

            $value = self::creare_modal();
        }
        return $value;
    }


}