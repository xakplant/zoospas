<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 10.09.2018
 * Time: 11:21
 */
//todo переписать название шорткода
add_shortcode('zs_meta_array', 'zs_print_filter_n_results');

function zs_print_filter_n_results(){

    // Подключение скриптов и стилей
    do_action('zoospas_enqueue');

    // Печать фильтра
    do_action('zs_print_filter');

    // Контейнер для вывода результатов по AJAX
    do_action('zs_result_filer_box');

    // Напечатать AJAX скрипт


}



//todo переписайть
function zs_meta_array(){

    global $wpdb;
    $sql = 'SELECT `meta_key`, `meta_value` FROM `wp_postmeta` WHERE meta_key=\'_zs_age\' OR meta_key=\'_zs_sex\' OR meta_key=\'_zs_pet_type\';';

    $result = $wpdb->get_results($sql, ARRAY_A);

    $column = [];
    $callWalk = function ($value) use (&$column) {$column[$value['meta_key']][] = $value['meta_value'];};
    array_walk($result, $callWalk);

    foreach ($column as &$col) {
        $col = array_unique($col);
    }

    return $column;


}
//todo переписайть
add_action('zs_print_filter', 'print_select');
function print_select(){

    $array = zs_meta_array();

    echo '<div><form data-type="zs_ajaz_form">';

        foreach ($array as $key=>$value){

            echo '<div data-type="zs_filter"><label>' . __(substr($key, 4), 'zoospas') . '</label><br>';
            echo '<select name="'. $key .'" data-value="' .$key. '">';

                    foreach ($value as $val){

                        echo '<option>'. $val .'</option>';

                    }

            echo '</select></div>';

        }

        echo '<button type="submit" data-type="zs_ajax_btn" class="btn-zs-default">' . __('Select', 'zoospas'). '</button>';

    echo '</form></div>';


}


// Контейнер для вывода результатов по AJAX
add_action('zs_result_filer_box', 'zs_ajax_box');
function zs_ajax_box(){

    echo '<div data-type="zs_ajax_box">Вывел</div>';

}



// Обработка AJAX

add_action( 'wp_enqueue_scripts', 'zs_localize', 99 );
function zs_localize(){

    wp_localize_script('zoospas_front', 'zs_filter',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );

}

add_action('wp_footer', 'my_action_javascript', 99); // для фронта
function my_action_javascript() {
    ?>
    <script type="text/javascript" >

        var zs_submiy = document.querySelector('[data-type="zs_ajax_btn"]');



        function ZS_submitListener(){
            event.preventDefault();

            var form = document.querySelector('[data-type="zs_ajaz_form"]');
            var data = new FormData(form);



           // data = JSON.stringify(data);

            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200){
                    document.querySelector('[data-type="zs_ajax_box"]').innerHTML = this.responseText;
                }
            };


            xhttp.open('POST', zs_filter.url + "?action=zs_filtered", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //xhttp.setRequestHeader('Content-Type', 'multipart/form-data');
           /*var mass = [
                        lex => '15',
                ];*/

            xhttp.send(data);




        }
        window.addEventListener('click', ZS_submitListener, zs_submiy);







    </script>
    <?php
}

add_action('wp_ajax_zs_filtered', 'my_action_callback');
add_action('wp_ajax_nopriv_zs_filtered', 'my_action_callback');
function my_action_callback() {

    $whatever = intval( $_POST['lex'] );
    echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';
    echo '<br>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    echo '<br>';

    echo $whatever + 10;


    wp_die();
}

