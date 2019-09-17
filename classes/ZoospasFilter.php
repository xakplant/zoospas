<?php
/**
 * @package Zoospas
 */

class ZoospasFilter
{


    public static function zs_get_meta_key(){

        global $wpdb;

        $sql = 'SELECT DISTINCT `meta_key` FROM `wp_postmeta` WHERE `meta_key` REGEXP "_zs_"';

        $result = $wpdb->get_results($sql, ARRAY_A);

        $result = array_column($result, 'meta_key');

        return $result;

    }

    public static function zs_get_arr_metadata(){


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


    }

    public static function zs_print_filter(){


        $array = self::zs_get_arr_metadata();
        
?>
<div class="zs__filter__wrapper">
<?php         
        /**
         * front-pages/events.php
         */
        do_action('zs_filter_wrap_start', 'data-type="zs_ajaz_form"');


        ?>
  <div class="s__filter">
    <div class="s_container">
      <div class="filter">
                
        <?php

        
        foreach ($array as $key=>$value){
            
            do_action('zs_filter_select_wrap_start', $key);

            echo '<select name="'. $key .'" data-value="' .$key. '">';

            foreach ($value as $val){

                echo '<option value="'. $val .'">'. __($val, 'zoospas') .'</option>';

            }

            echo '</select>';
            
            ?>
              <div data-delay="0" class="filter_drop w-dropdown">
                <div class="dropdown-toggle w-dropdown-toggle">
                  <div class="icon w-icon-dropdown-toggle"></div>
                  <div class="filter__placehoder-current"><?php esc_html_e($value[0], 'zoospas');?></div>
                </div>
                <nav class="dropdown-list w-dropdown-list">
                  <?php foreach ($value as $val){?>
                  <a href="#" class="filter__placehoder w-dropdown-link" data-value="<?php echo $val;?>"><?php esc_html_e($val, 'zoospas');?></a>
                  <?php }?>
                </nav>
              </div>
            <?php 

            do_action('zs_filter_select_wrap_end');


        }

        do_action('zs_filter_print_button', 'data-type="zs_ajax_btn"');

        ?>
        </div>
      </div>
    </div>
        <?php 
        
        do_action('zs_filter_wrap_end');
?>

</div>

<?php 
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

                    foreach ($keys as $key):

                ?>

                data.<?php echo $key; ?> = document.querySelector('select[data-value="<?php echo $key; ?>"]').value;

                <?php

                    endforeach;

                ?>


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

    public static function zs_filert_ajax_script_string(){
        $script_text = 'var zs_submiy = document.querySelector(\'[data-type="zs_ajax_btn"]\');';
        $script_text .= 'function ZS_submitListener(event){';
            $script_text .= 'event.preventDefault();';
            $script_text .= 'var data = new Object();';

            $keys = self::zs_get_meta_key();
            foreach ($keys as $key){
                $script_text .= 'data.' . $key . ' = document.querySelector(\'select[data-value="' . $key . '"]\').value;';
            }


            $script_text .= 'data = JSON.stringify(data);';
            $script_text .= 'var xhttp = new XMLHttpRequest();';
            $script_text .= 'xhttp.onreadystatechange = function () {
                    if(this.readyState == 4 && this.status == 200){
                        document.querySelector(\'[data-type="zs_ajax_box"]\').innerHTML = this.responseText;
                    }
                };';
            $script_text .= 'xhttp.open(\'POST\', zs_filter.url + "?action=zs_filtered", true);';
            $script_text .= 'xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");';
            $script_text .= 'xhttp.send("data="+data);';


        $script_text .= '}';
        $script_text .= 'zs_submiy.addEventListener(\'click\', ZS_submitListener, zs_submiy);';
        return $script_text;
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
            
            ob_start();
            while ( $query->have_posts() ) :
                $query->the_post();

                /**
                 * @hook zs_print_pet_card 10
                 * file front-pages/functions.php
                 */
                do_action('zs_print_pet_card');


            endwhile;
            
            echo zs_wrap_cards_list(ob_get_clean());

        }
        else {

            echo '<h2>'. __('Not Found', 'zoospas') .'</h2>';

        }





        wp_die();

    }

}
