<?php
/**
 * @package Zoospas
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
        
        $form .= '<div class="zs__filter__wrapper zs__contact__wrapper"><div class="s__filter"><div class="s_container"><div class="filter zs-contact-form">';

        $form .= '<form class="' . $form_class . '" action="' . esc_url( admin_url('admin-post.php') ) . '" method="post">';
        $form .= '<input type="hidden" name="action" value="' . $action . '">';
        $form .= '<select class="" style="display: none;" name="subject" id="subject ">';
        foreach ($subjects as $subject){
            $form .= '<option>' . __($subject, 'zoospas') . '</option>';
        }
        $form .= '</select>';
        
        ob_start();
        ?>
          <div data-delay="0" class="filter_drop w-dropdown">
            <div class="dropdown-toggle w-dropdown-toggle">
              <div class="icon w-icon-dropdown-toggle"></div>
              <div class="filter__placehoder-current"><?php esc_html_e($subjects[0], 'zoospas');?></div>
            </div>
            <nav class="dropdown-list w-dropdown-list">
              <?php foreach ($subjects as $subject){?>
              <a href="#" class="filter__placehoder w-dropdown-link" data-value="<?php echo __($subject, 'zoospas');?>"><?php echo __($subject, 'zoospas');?></a>
              <?php }?>
            </nav>
          </div>
        <?php 
        $form .= str_replace(array("\r","\n"),'', ob_get_clean());
        
        $form .= '<input class="w-input" type="email" name="email" placeholder="' . __('Add Email', 'zoospas') . '"/>';
        $form .= '<input class="w-input" type="tel" name="tel" required placeholder="' . __('Add Phone', 'zoospas') . '" />';

        $form .= '<div class=""><button class="btn_primary w-button ' . $class_btn . '" type="submit">'. __('send', 'zoospas') .'</button></div>';
        $form .= '</form>';
        
        $form .= '</div></div></div></div>';

        return $form;
    }

    public static function creare_modal(){
        $text = self::$text;
        $class = self::$class;
        $id = self::$html_id;

        $modal = '';

        $modal .= '<a href="javascript:void(0);" class="' . $class . '" id="' . $id . '">' . $text . '</a>';

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