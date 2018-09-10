<?php
/**
 * @package Zoospas
 */
/*
Plugin Name: Zoospas project for Hakaton
Plugin URI: https://web.799000.ru/
Description:
Version: 0.1.0
Author: ANIT
Author URI: https://799000.ru/
License: GPLv2 or later
Text Domain: zoospas
*/

// todo удалить комментарии
/**
 * Произвольное поле возраст
 */
// Добавляем блоки в основную колонку на страницах постов и пост. страниц
add_action('add_meta_boxes_zs_pets', 'zs_add_custom_box_age');
function zs_add_custom_box_age(){
    add_meta_box( 'zs_age', __('Age', 'zoospas'), 'zs_age_meta_box_callback', 'zs_pets' );
}

// HTML код блока
function zs_age_meta_box_callback( $post, $meta ){
    $screens = $meta['args'];



    // Используем nonce для верификации
    wp_nonce_field( plugin_basename(__FILE__), 'zoospas_noncename' );

    // Поля формы для введения данных
    echo '<label for="zs_age_field">' . __("Put pet age", 'zoospas' ) . '</label> ';
    echo '<input type="text" id= "zs_age_field" name="zs_age_field" size="2"  value="'. get_post_meta( $post->ID, '_zs_age',true ) .'"/>';


}

// Сохраняем данные, когда пост сохраняется
add_action( 'save_post', 'zs_age_save_postdata' );
function zs_age_save_postdata( $post_id ) {
    // Убедимся что поле установлено.
    if ( ! isset( $_POST['zs_age_field'] ) )
        return;

    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if ( ! wp_verify_nonce( $_POST['zoospas_noncename'], plugin_basename(__FILE__) ) )
        return;

    // если это автосохранение ничего не делаем
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    // проверяем права юзера
    if( ! current_user_can( 'edit_post', $post_id ) )
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $my_data = sanitize_text_field( $_POST['zs_age_field'] );

    // Обновляем данные в базе данных.
    update_post_meta( $post_id, '_zs_age', $my_data );
}

/**
 * Произвольное поле Пол
 */
// Добавляем блоки в основную колонку на страницах постов и пост. страниц
add_action('add_meta_boxes_zs_pets', 'zs_add_custom_box_sex');
function zs_add_custom_box_sex(){
    add_meta_box( 'zs_sex', __('Sex', 'zoospas'), 'zs_sex_meta_box_callback', 'zs_pets' );
}
// HTML код блока
function zs_sex_meta_box_callback( $post, $meta ){
    $screens = $meta['args'];

    // Используем nonce для верификации
    wp_nonce_field( plugin_basename(__FILE__), 'zoospas_noncename' );

    // Поля формы для введения данных
    echo '<label for="zs_sex_field">' . __("Put pet sex", 'zoospas' ) . '</label> ';


    get_post_meta( $post->ID, '_zs_age',true );

    $arr_sex = [ 'Male','Famale'];

    echo '<select type="text" id="zs_sex_field" name="zs_sex_field">';

    foreach ($arr_sex as $sex){

        if($sex ===  get_post_meta( $post->ID, '_zs_sex',true )){
            echo '<option selected>'. __($sex, 'zoospas') .'</option>';
        }
        else {
            echo '<option>'. __($sex, 'zoospas') .'</option>';
        }

    }

    echo '</select>';
}
// Сохраняем данные, когда пост сохраняется
add_action( 'save_post', 'zs_sex_save_postdata' );
function zs_sex_save_postdata( $post_id ) {
    // Убедимся что поле установлено.
    if ( ! isset( $_POST['zs_sex_field'] ) )
        return;

    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if ( ! wp_verify_nonce( $_POST['zoospas_noncename'], plugin_basename(__FILE__) ) )
        return;

    // если это автосохранение ничего не делаем
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    // проверяем права юзера
    if( ! current_user_can( 'edit_post', $post_id ) )
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $my_data = sanitize_text_field( $_POST['zs_sex_field'] );

    // Обновляем данные в базе данных.
    update_post_meta( $post_id, '_zs_sex', $my_data );
}


/**
 * Произвольное поле Тип животного
 */
// Добавляем блоки в основную колонку на страницах постов и пост. страниц
add_action('add_meta_boxes_zs_pets', 'zs_add_custom_box_pet_type');
function zs_add_custom_box_pet_type(){
    add_meta_box( 'zs_pet_type', __('Type', 'zoospas'), 'zs_pet_type_meta_box_callback', 'zs_pets' );
}
// HTML код блока
function zs_pet_type_meta_box_callback( $post, $meta ){
    $screens = $meta['args'];


    // Используем nonce для верификации
    wp_nonce_field( plugin_basename(__FILE__), 'zoospas_noncename' );

    // Поля формы для введения данных
    echo '<label for="zs_sex_field">' . __("Put pet type", 'zoospas' ) . '</label> ';


    get_post_meta( $post->ID, '_zs_pet_type',true );

    $arr_pet_type = [ 'Cat','Dog', 'Other'];

    echo '<select type="text" id="zs_pet_type_field" name="zs_pet_type_field">';

    foreach ($arr_pet_type as $pet_type){

        if($pet_type ===  get_post_meta( $post->ID, '_zs_pet_type',true )){
            echo '<option selected>'. __($pet_type, 'zoospas') .'</option>';
        }
        else {
            echo '<option>'. __($pet_type, 'zoospas') .'</option>';
        }

    }

    echo '</select>';
}
// Сохраняем данные, когда пост сохраняется
add_action( 'save_post', 'zs_pet_type_save_postdata' );
function zs_pet_type_save_postdata( $post_id ) {
    // Убедимся что поле установлено.
    if ( ! isset( $_POST['zs_pet_type_field'] ) )
        return;

    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if ( ! wp_verify_nonce( $_POST['zoospas_noncename'], plugin_basename(__FILE__) ) )
        return;

    // если это автосохранение ничего не делаем
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    // проверяем права юзера
    if( ! current_user_can( 'edit_post', $post_id ) )
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $my_data = sanitize_text_field( $_POST['zs_pet_type_field'] );

    // Обновляем данные в базе данных.
    update_post_meta( $post_id, '_zs_pet_type', $my_data );
}