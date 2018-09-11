<?php

/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 11.09.2018
 * Time: 15:47
 */
class ZoospasFilter
{

    private static function zs_get_meta_key(){

        global $wpdb;

        $sql = 'SELECT DISTINCT `meta_key` FROM `wp_postmeta` WHERE `meta_key` LIKE "_zs_%"';

        $result = $wpdb->get_results($sql, ARRAY_A);

        $result = array_column($result, 'meta_key');

        return $result;

    }

    private static function zs_get_arr_metadata(){


        $arWhere = self::zs_get_meta_key();

        $where = "meta_key='" . implode("' OR meta_key='", $arWhere) . "'";

        global $wpdb;

        $sql = 'SELECT `meta_key`, `meta_value` FROM `wp_postmeta` WHERE '. $where.';';

        $result = $wpdb->get_results($sql, ARRAY_A);

        $column = [];
        $callWalk = function ($value) use (&$column) {$column[$value['meta_key']][] = $value['meta_value'];};
        array_walk($result, $callWalk);

        foreach ($column as &$col) {
            $col = array_unique($col);
        }

        return $column;

/*        echo '<pre>';
        print_r($column);
        echo '</pre>';*/

    }

    public static function zs_print_filter(){


        $array = self::zs_get_arr_metadata();

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

    public static function zs_print_result_box(){

        echo '<div data-type="zs_ajax_box"></div>';

    }

    public static function zs_localize_script(){

        wp_localize_script('zoospas_front', 'zs_filter',
            array(
                'url' => admin_url('admin-ajax.php')
            )
        );

    }

    public static function zs_filert_ajax_script(){

        ?>

        <script type="text/javascript" >

            var zs_submiy = document.querySelector('[data-type="zs_ajax_btn"]');



            function ZS_submitListener(event){
                event.preventDefault();

                var data = new Object();

                <?php

                $keys = self::zs_get_meta_key();

                    foreach ($keys as $key):?>

                data.<?php echo $key; ?> = document.querySelector('select[data-value="<?php echo $key; ?>"]').value;

                <?php endforeach; ?>


                data = JSON.stringify(data);


                var xhttp = new XMLHttpRequest();


                xhttp.onreadystatechange = function () {
                    if(this.readyState == 4 && this.status == 200){
                        document.querySelector('[data-type="zs_ajax_box"]').innerHTML = this.responseText;
                    }
                };


                xhttp.open('POST', zs_filter.url + "?action=zs_filtered", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhttp.send("data="+data);

            }

            zs_submiy.addEventListener('click', ZS_submitListener, zs_submiy);

        </script>

        <?php
    }

    public static function zs_filter_handler(){

        $arrFilter = json_decode(stripslashes($_POST['data']), true);


        $argmts = [

            'post_type'=>'zs_pets',
            'meta_query' => [
                'relation' => 'AND',
            ],
        ];

        foreach ($arrFilter as $key => $value) {
            $argmts['meta_query'][] = ['key' => $key, 'value' => $value];
        }

        $query = new WP_Query($argmts);

        if($query->have_posts()){

            while ( $query->have_posts() ) :
                $query->the_post();

                the_title('<h2>', '</h2>');

                echo '<img src="' .get_the_post_thumbnail_url() . '"/>';

                the_content();
                the_excerpt();

            endwhile;

        }
        else {

            echo '<h2>'. __('Not Found', 'zoospas') .'</h2>';

        }



        wp_die();

    }

}