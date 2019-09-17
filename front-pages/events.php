<?php
/**
 * @package Zoospas
 */



add_action('zs_filter_wrap_start', 'zs_filter_wrap_start', 10, 1);
function zs_filter_wrap_start($zs_attribute){
    echo '<div class="zs_filter_block"><form ' . $zs_attribute . '>';
}
add_action('zs_filter_select_wrap_start', 'zs_filter_select_wrap_start', 10, 1);
function zs_filter_select_wrap_start($key){
    $title = ucfirst(str_replace("_", " ", substr($key, 4)));
    ?>
    <div class="filter__container">
    	<div class="filter__label-name"><?php _e($title, 'zoospas');?></div>
    <?php 
    echo '<div data-type="zs_filter"><label>' . __($title, 'zoospas') . '</label><br>';
}
add_action('zs_filter_select_wrap_end', 'zs_filter_select_wrap_end', 10);
function zs_filter_select_wrap_end(){
    echo '</div>';
    ?>
    </div>
    <?php 
}

add_action('zs_filter_print_button', 'zs_filter_print_button', 10, 1);
function zs_filter_print_button($zs_attribute){
    echo '<div class="btn_container"><button type="submit" ' . $zs_attribute . ' class="btn-zs-default btn_primary w-button">' . __('Select', 'zoospas'). '</button></div>';
}

add_action('zs_filter_wrap_end', 'zs_filter_wrap_end', 10);
function zs_filter_wrap_end(){
    echo '</form></div>';
}


