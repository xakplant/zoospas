<?php
/**
* @package Zoospas
*/
add_action('zs_sp_title', 'zs_sp_title', 10);
function zs_sp_title(){
    the_title('<h1>', '</h1>');
}
add_action('zs_sp_content', 'zs_sp_content', 10);
function zs_sp_content(){
    the_content();
}
add_action('zs_sp_content_strip_buttons', 'zs_sp_content_strip_buttons', 10);
function zs_sp_content_strip_buttons(){
    echo apply_filters( 'the_content', zs_remove_buttons_shortcodes(get_the_content()) );
}
add_action('zs_sp_thumbnail', 'zs_sp_thumbnail');
function zs_sp_thumbnail(){
    echo get_the_post_thumbnail( $id, array('410', '410'), null );
}
add_action('zs_sp_thumbnail_url', 'zs_sp_thumbnail_url');
function zs_sp_thumbnail_url(){
    echo get_the_post_thumbnail_url( $id, array('410', '410') );
}
add_action('zs_p_cardmeta', 'zs_p_cardmeta');
function zs_p_cardmeta(){
    $arr_keys = ZoospasFilter::zs_get_meta_key();
    $arr_values = [];

    $arr_alias = zs_get_meta_key_alias();

    foreach ($arr_keys as $key){
        $arr_values[$key] = get_post_custom_values( $key, $post->ID );
    }

    echo '<table class="zoospas_p_table"><tbody>';
    foreach ($arr_values as $key=>$value){
        echo '<tr>';
        echo '<th>' . __($arr_alias[$key], 'zss') . '</th>';
        echo '<td>' . __($value[0], 'zoospas') . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
add_action('zs_p_cardmeta_v2_div', 'zs_p_cardmeta_v2_div');
function zs_p_cardmeta_v2_div(){
    $arr_keys = ZoospasFilter::zs_get_meta_key();
    $arr_values = [];
    
    $arr_alias = zs_get_meta_key_alias();
    
    foreach ($arr_keys as $key){
        $arr_values[$key] = get_post_custom_values( $key );
    }
    
    ?>
      <div class="c__card">
      <?php foreach ($arr_values as $key=>$value){ ?>
        <div class="card__spec info-page">
          <div class="card__label-name"><?php esc_html_e($arr_alias[$key], 'zss');?></div>
          <div class="card__value"><?php esc_html_e($value[0], 'zoospas'); ?></div>
        </div>
      <?php }?>
      </div>
	<?php    
}


