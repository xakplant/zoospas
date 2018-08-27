<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 11:46
 */


add_action('wp_footer', 'zs_get_bitrix_open_line', 100);
function zs_get_bitrix_open_line(){
    ?>

    <script data-skip-moving="true">
        (function(w,d,u){
            var s=d.createElement('script');s.async=1;s.src=u+'?'+(Date.now()/60000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn.bitrix24.ru/b7941911/crm/site_button/loader_4_jxb0l8.js');
    </script>

    <?php
}
