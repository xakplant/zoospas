<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25.08.2018
 * Time: 14:57
 */

require_once ( ZOOSPAS_PLUGIN_DIR . '/shortcodes/filter.php' );

function zs_get_button_action($text, $class, $url, $id){
    return '<a class="' . $class . '" href="'. $url .'" id="' . $id . '">'. $text .'</a>';
}
add_action('zs_button_left', 'zs_print_button_left_action');
function zs_print_button_left_action(){
    $zs_options = ZoospasVars::$options;
    $text = $zs_options['buttons']['left']['text'];
    $class = $zs_options['buttons']['left']['class'];
    $url = $zs_options['buttons']['left']['url'];
    $html_id = $zs_options['buttons']['left']['html_id'];

    echo zs_get_button_action($text, $class, $url, $html_id);
}
add_shortcode('zs_button_left', 'zs_print_button_left');
function zs_print_button_left(){

    $zs_options = ZoospasVars::$options;
    $text = $zs_options['buttons']['left']['text'];
    $class = $zs_options['buttons']['left']['class'];
    $url = $zs_options['buttons']['left']['url'];
    $html_id = $zs_options['buttons']['left']['html_id'];

    ob_start();
    echo zs_get_button_action($text, $class, $url, $html_id);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_action('zs_button_right', 'zs_print_button_right_action');
function zs_print_button_right_action(){
    $zs_options = ZoospasVars::$options;
    $text = $zs_options['buttons']['right']['text'];
    $class = $zs_options['buttons']['right']['class'];
    $url = $zs_options['buttons']['right']['url'];
    $html_id = $zs_options['buttons']['right']['html_id'];

    echo zs_get_button_action($text, $class, $url, $html_id);
}
add_shortcode('zs_button_right', 'zs_print_button_right');
function zs_print_button_right(){
    $zs_options = ZoospasVars::$options;
    $text = $zs_options['buttons']['right']['text'];
    $class = $zs_options['buttons']['right']['class'];
    $url = $zs_options['buttons']['right']['url'];
    $html_id = $zs_options['buttons']['right']['html_id'];

    ob_start();
    echo zs_get_button_action($text, $class, $url, $html_id);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/**
 * Form
 */
add_shortcode('zs_form', 'zs_recall_form');
function zs_recall_form(){

    new ZoospasForm();
    wp_enqueue_style('zoospas_style_front');
    ob_start();
    echo ZoospasForm::get_value();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_action('zs_form', 'zs_recall_form_action');
function zs_recall_form_action(){
    new ZoospasForm();
    wp_enqueue_style('zoospas_style_front');
    echo ZoospasForm::get_value();
}


add_action( 'admin_post_zoospas_form', 'zoospas_form_action' );
add_action( 'admin_post_nopriv_zoospas_form', 'zoospas_form_action' );
function zoospas_form_action(){
    $args = $_POST;

    $to = ZoospasVars::$options['form']['email'];
    $to = sanitize_email($to);
    $subject = $args['subject'];
    $email = $args['email'];
    $phone = $args['tel'];

    $headers = array(
        'From: Zoospas <info@zoospas.ru>',
        'content-type: text/html; charset=UTF-8',
        'Cc: John Q Codex <'. $to  .'',
        'Cc: '. $to
    );

    $message = '';
    $message .= '<table>';
    $message .= '<thead><tr><td>' . __('New appeal from the site') . '</td></tr></thead>';
    $message .= '<tbody>';
    $message .= '<tr><td>' . __('Email', 'zoospas') . '</td><td>' . $email . '</td></tr>';
    $message .= '<tr><td>' . __('Phone number', 'zoospas') . '</td><td>' . $phone . '</td></tr>';

    $message .= '</tbody></table>';

    $responce = wp_mail( $to, $subject, $message, $headers );

    $addr = $_SERVER['HTTP_REFERER'];
    $addr = str_replace('?zs_mail_responce=true', '', $addr);
    $addr = str_replace('?zs_mail_responce=false', '', $addr);
    $concat = '';


    if($responce == true){
        $concat = '?zs_mail_responce=true';
        header('Location: ' . $addr . $concat);
        exit;
    } else {
        $concat = '?zs_mail_responce=false';
        header('Location: ' . $addr . $concat);
        exit;
    }
}

/**
 * Print pets list of type
 */
add_action('pre_get_posts', 'zoospas_query_offset', 1 );
function myprefix_query_offset(&$query) {
    if ( ! $query->is_posts_page ) {
        return;
    }
}



add_shortcode('zs_pets_list', 'zs_print_pets_list_of_type_action');
function zs_print_pets_list_of_type_action($attr, $content = null){
    $type = $attr['type'];
    $calc = get_option( 'posts_per_page' );
    $paged = $GLOBALS['wp_query']->query_vars['paged'];
    if($paged){
        $offset = $calc * ($paged - 1);
    } else {
        $offset = 0;
    }
    $argmts = [

        'post_type'=>'zs_pets',
        'offset'=>$offset,
        'meta_query' => [
            [
                'relation '=>'OR',
                'key'=>'_zs_pet_type',
                'value'=>$type,
                'compare'=>'LIKE',
            ]
        ]
    ];
    $query = new WP_Query($argmts);



    if($query->have_posts()){
        ob_start();
        while ( $query->have_posts() ) :
            $query->the_post();
            /**
             * @hook zs_print_pet_card 10
             * file front-pages/functions.php
             */
            do_action('zs_print_pet_card');
        endwhile;


        $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
        the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Previous page', 'zoospas' ), 'next_text' => __( 'Next page', 'zoospas' ), 'screen_reader_text' => __( 'Posts navigation' ) ) );


        wp_reset_query();
        return ob_get_clean();
    } else {
        ob_start();
        echo '<h2>'. __('Not Found', 'zoospas') .'</h2>';
        return ob_get_clean();
    }



}
add_action('zs_pets_list', 'zs_print_pets_list_of_type', 10, 1);
function zs_print_pets_list_of_type($type){
    $calc = get_option( 'posts_per_page' );
    $paged = $GLOBALS['wp_query']->query_vars['paged'];
    if($paged){
        $offset = $calc * ($paged - 1);
    } else {
        $offset = 0;
    }
    $argmts = [

        'post_type'=>'zs_pets',
        'offset'=>$offset,
        'meta_query' => [
            [
                'relation '=>'OR',
                'key'=>'_zs_pet_type',
                'value'=>$type,
                'compare'=>'LIKE',
            ]
        ]
    ];
    $query = new WP_Query($argmts);
    if($query->have_posts()){
        while ( $query->have_posts() ) :
            $query->the_post();

            /**
             * @hook zs_print_pet_card 10
             * file front-pages/functions.php
             */
            do_action('zs_print_pet_card');

        endwhile;

        $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
        the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Previous page', 'zoospas' ), 'next_text' => __( 'Next page', 'zoospas' ), 'screen_reader_text' => __( 'Posts navigation' ) ) );

    } else {
        echo '<h2>'. __('Not Found', 'zoospas') .'</h2>';
    }
    wp_reset_query();

}
