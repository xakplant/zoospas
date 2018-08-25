<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 11:46
 */
/**
 * Events
 * zs_admin_panel - print data on page "Admin panel"
 * zs_pet_list - print data on page "Pet list"
 * zs_general_content_of_pages_before_content - print data on all pages before general contents this pages
 * zs_general_content_of_pages_after_content - print data on all pages after general contents this pages
 *
 */
add_action('zs_admin_panel', 'zs_admin_panel', 10);
add_action('zs_pet_list', 'zs_pet_list', 10);
add_action( 'zs_admin_panel', 'example_table_page_load', 20 );
add_action( 'zs_admin_panel', 'expl', 30 );


add_filter( 'set-screen-option', function( $status, $option, $value ){
    return ( $option == 'lisense_table_per_page' ) ? (int) $value : $status;
}, 10, 3 );


function example_table_page_load(){

    require_once( ZOOSPAS_PLUGIN_DIR . 'Example_List_Table.php' );


    // создаем экземпляр и сохраним его дальше выведем
    $GLOBALS['Example_List_Table'] = new Example_List_Table();
}
function expl() {

    echo '<form action="" method="POST">';
    $GLOBALS['Example_List_Table']->display();
    echo '</form>';


}
function zs_admin_panel(){
    ?>

        <p>Контент для Административной панели</p>

    <?php


}
function zs_pet_list(){
    ?>

        <p>Контент для Списка животных</p>

    <?php
}

