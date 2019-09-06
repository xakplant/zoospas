<?php
/**
 * @package Zoospas
 */


/**
 * Pet card in filter
 */
function zs_print_pet_card(){
    global $post;
    $zs_options = ZoospasVars::$options;
    
    // Wraper start
    do_action('zs_card_wraper_start');
    
    ?>
    <div class="card__image" style="background-image: url('<?php do_action('zs_sp_thumbnail_url'); ?>');"></div>
    <div class="card__info">
    
    <?php if ( has_shortcode( $post->post_content, 'zs_button_left' ) ) {?>
    <a href="<?php echo $zs_options['buttons']['left']['url'];?>" data-w-id="0ada954c-95da-4437-7a63-692dc7c35cf0" class="card__like">
    <div class="heart-img w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M11.9998 21C11.8682 21.0008 11.7377 20.9756 11.6159 20.9258C11.4941 20.876 11.3833 20.8027 11.2898 20.71L3.51982 12.93C2.54518 11.9452 1.99848 10.6156 1.99848 9.23002C1.99848 7.84445 2.54518 6.51484 3.51982 5.53002C4.50208 4.55053 5.83265 4.00049 7.21982 4.00049C8.60699 4.00049 9.93756 4.55053 10.9198 5.53002L11.9998 6.61002L13.0798 5.53002C14.0621 4.55053 15.3926 4.00049 16.7798 4.00049C18.167 4.00049 19.4976 4.55053 20.4798 5.53002C21.4545 6.51484 22.0012 7.84445 22.0012 9.23002C22.0012 10.6156 21.4545 11.9452 20.4798 12.93L12.7098 20.71C12.6164 20.8027 12.5056 20.876 12.3837 20.9258C12.2619 20.9756 12.1314 21.0008 11.9998 21ZM7.21982 6.00002C6.79649 5.9981 6.377 6.0802 5.98563 6.24155C5.59425 6.40291 5.23879 6.64031 4.93982 6.94002C4.33588 7.54714 3.99685 8.36866 3.99685 9.22502C3.99685 10.0814 4.33588 10.9029 4.93982 11.51L11.9998 18.58L19.0598 11.51C19.6638 10.9029 20.0028 10.0814 20.0028 9.22502C20.0028 8.36866 19.6638 7.54714 19.0598 6.94002C18.4435 6.35773 17.6277 6.03331 16.7798 6.03331C15.9319 6.03331 15.1162 6.35773 14.4998 6.94002L12.7098 8.74002C12.6169 8.83374 12.5063 8.90814 12.3844 8.95891C12.2625 9.00968 12.1318 9.03581 11.9998 9.03581C11.8678 9.03581 11.7371 9.00968 11.6152 8.95891C11.4934 8.90814 11.3828 8.83374 11.2898 8.74002L9.49982 6.94002C9.20085 6.64031 8.84538 6.40291 8.45401 6.24155C8.06264 6.0802 7.64314 5.9981 7.21982 6.00002V6.00002Z"></path>
    </svg></div>
    </a>
    <?php }?>
    
    <a href="<?php the_permalink();?>" class="card__title w-inline-block">
    	<span class="text-block"><?php do_action('zs_card_title');?></span>
    </a>
    <?php do_action('zs_card_meta_v2_div');?>
    
    <?php if ( has_shortcode( $post->post_content, 'zs_button_left' ) ) {?>
    <div class="spacer _16"></div><?php echo do_shortcode('[zs_button_left]');?>
    <?php }?> 
    
    <?php if ( has_shortcode( $post->post_content, 'zs_button_right' ) ) {?>
    <div class="spacer _16"></div><?php echo do_shortcode('[zs_button_right]');?>
    <?php }?> 
    
    </div>	<!-- card__info -->
    
    <?php

    // Excerpt
    //do_action('zs_card_excerpt');

    // Meta
    //do_action('zs_card_meta');

    // Thumb
    //do_action('zs_card_thumbnail');

    // Content
     //do_action('zs_card_content');

     // Admin Edit
    do_action('zs_admin_edit_post');

    // Wraper end
    do_action('zs_card_wraper_end');

}

add_action('zs_print_pet_card', 'zs_print_pet_card', 10);
add_shortcode('zs_print_pet_card', 'zs_print_pet_card');

function zs_card_wraper_start(){
    echo '<div class="card zs_card">';
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

function zs_card_thumbnail_url(){
    
    echo get_the_post_thumbnail_url();
    
}
add_action('zs_card_thumbnail_url', 'zs_card_thumbnail_url', 20);

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

function zs_card_meta_v2_div(){
    $arr_keys = ZoospasFilter::zs_get_meta_key();
    $arr_values = [];
    
    $arr_alias = zs_get_meta_key_alias();
    
    foreach ($arr_keys as $key){
        $arr_values[$key] = get_post_custom_values( $key );
    }
    
    ?>
      <div class="c__card">
      <?php foreach ($arr_values as $key=>$value){ ?>
        <div class="card__spec">
          <div class="card__label-name"><?php esc_html_e($arr_alias[$key], 'zss');?></div>
          <div class="card__value"><?php esc_html_e($value[0], 'zoospas'); ?></div>
        </div>
      <?php }?>
      </div>
	<?php    
}
add_action('zs_card_meta_v2_div', 'zs_card_meta_v2_div');

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
    /**
     * TODO удалить ошибку на wp
     */
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
add_action('zs_admin_edit_post', 'zs_admin_edit_post', 10);



/**
 * Meta key alias
 */
function zs_get_meta_key_alias(){
    return [
        '_zs_age'=> __('Age', 'zoospas'),
        '_zs_sex'=> __('Sex', 'zoospas'),
        '_zs_size'=> __('Size', 'zoospas'),
        '_zs_pet_type'=> __('Type', 'zoospas'),
    ];
}


/**
 * Default pet card page
 *
 */
add_filter( 'template_include', 'zs_template_redirect_for_default_theme' );
function zs_template_redirect_for_default_theme( $original_template ) {
    if (get_post_type() == "zs_pets"){
        if(!file_exists(get_template_directory() . '/single-zs_pets.php') && !file_exists(get_stylesheet_directory() . '/single-zs_pets.php')){
            return ZOOSPAS_PLUGIN_DIR . '/templates/single.php';
        }
        else {
            return $original_template;
        }

    }
    else {
        return $original_template;
    }
}