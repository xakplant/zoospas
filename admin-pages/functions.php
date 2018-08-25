<?php
/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 11:46
 */
function zoospas_register_css_js(){
    wp_register_script('zoospas_script', ZOOSPAS_PLUGIN_URL . 'assets/js/main.js', '', '1.0', true);
    wp_register_style('zoospas_style', ZOOSPAS_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');
}
add_action('admin_enqueue_scripts ', 'zoospas_register_css_js');




/**
 *
 * Ввод списка животных из записей
 *
 */
add_action('zs_pet_list', 'zs_print_petlist_admin', 20);
function zs_print_petlist_admin(){

    
   $query = new WP_Query(array('post_type'=>'post', 'category_name'=>'pet'));
   

       
   while($query->have_posts()): $query->the_post();?>

    <div class="lit-item">
        <span><?php the_title('<a href="'. get_permalink() .'">', '</a>'); ?></span>
        <span><?php the_content(); ?></span>
        <span><?php get_the_post_thumbnail(); ?></span>
    </div>


    <?php endwhile;
    
}


add_action('zs_pet_list', 'zs_print_petlist_admin_cat', 30);
function zs_print_petlist_admin_cat(){

    
   $query = new WP_Query(array('post_type'=>'post', 'category_name'=>'cat'));
   
?>
<h2>Кошки</h2>
<?php
       
   while($query->have_posts()): $query->the_post();?>

    <div class="lit-item">
        <span><?php the_title('<a href="'. get_permalink() .'">', '</a>'); ?></span>
        <span><?php the_content(); ?></span>
        <span><?php get_the_post_thumbnail(); ?></span>
    </div>


    <?php endwhile;
    
}
add_action('zs_pet_list', 'zs_print_petlist_admin_dog', 40);
function zs_print_petlist_admin_dog(){

    
   $query = new WP_Query(array('post_type'=>'post', 'category_name'=>'dog'));
   
?>
<h2>Собаки</h2>
<?php
       
   while($query->have_posts()): $query->the_post();?>
	
    <div class="lit-item">
        <span><?php the_title('<a href="'. get_permalink() .'">', '</a>'); ?></span>
        <span><?php the_content(); ?></span>
        <span><?php get_the_post_thumbnail(); ?></span>
    </div>


    <?php endwhile;
    
}