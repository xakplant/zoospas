<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25.08.2018
 * Time: 14:57
 */
function zs_print_user_buttons(){
    ?>

        <div class="zs_button_block">

            <a class="zs-btn zs-btn-default" href="/petlist">Приютить животное</a>
            <a class="zs-btn zs-btn-default" href="/volontier">Предложить попощь</a>

        </div>

    <?php
    wp_enqueue_scripts('zoospas_script');
}
add_shortcode('zs_print_user_buttons', 'zs_print_user_buttons');

add_shortcode('zs_print_pet_list', 'zs_print_petlist_user');

function zs_print_petlist_user(){

    
   $query = new WP_Query(array('post_type'=>'post', 'category_name'=>'pet'));
   

       
   while($query->have_posts()): $query->the_post();?>

    <div class="lit-item">
        <span><?php the_title('<a href="'. get_permalink() .'">', '</a>'); ?></span>
        <span><?php the_content(); ?></span>
        <span><?php get_the_post_thumbnail(); ?></span>
    </div>


    <?php endwhile;
    
}


function zs_volontier_form(){

    ?>

    <form name="zs_volont_form" method="post">

        <input name="name" type="text" placeholder="Введите ваше имя"/>
        <input name="telephoen" type="tel" placeholder="Введите ваш телефое"/>
        <input name="email" type="email" placeholder="Введите ваш емаил">
        <input name="other" type="text" placeholder="Введите вашы соц. сети или примечание">
        <button type="submit">Отправить</button>

    </form>
    
    <div data-type="ajax-response"></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		$('form').on('submit', function(){
			event.preventDefault();

			var name = $('form input[name="name"]').val();
			var telephoen = $('form input[name="telephoen"]').val();
			var email = $('form input[name="email"]').val();
			var other = $('form input[name="other"]').val();

			
			$.post('/wp-admin/admin-ajax.php', 
			{'action': 'volonter_reg', 'name': name, 'telephoen': telephoen, 'email': email, 'other': other}, 
			function(response){
			    			    
			     $('[data-type="ajax-response"]').html(response);   
			});
			
		
			
		})
	</script>
	
    <?php

}

add_shortcode('zs_volontier_form', 'zs_volontier_form');

add_action('wp_ajax_volonter_reg', 'zs_volonter_reg');
add_action('wp_ajax_no_priv_volonter_reg', 'zs_volonter_reg');
function zs_volonter_reg(){
    $name = $_POST['name'];
    $telephoen = $_POST['telephoen'];
    $email = $_POST['email'];
    $other = $_POST['other'];

    echo $name . '<br>';
    echo $telephoen . '<br>';
    echo $email . '<br>';
    echo $other . '<br>';
    
    echo '<hr>';
    
    $message = $name . ' зарегистрировался на сайте Zoospas';
    $message .= ' его телефон' . $telephoen;
    $message .= ' его почта ' . $email;
    $message .= ' примечание "' . $other . '"';
    
    
    
    $call = wp_mail( 'cherr_guw@mail.ru', 'Новая регистрация', $message, $headers, $attachments );
    
    echo $call;

    wp_die();
}






function zs_after_post_form(){
    
    ?>
    <script id="bx24_form_button" data-skip-moving="true">
        (function(w,d,u,b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                (w[b].forms=w[b].forms||[]).push(arguments[0])};
                if(w[b]['forms']) return;
                var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://b24-pbobc0.bitrix24.ru/bitrix/js/crm/form_loader.js','b24form');

        b24form({"id":"8","lang":"ru","sec":"6ql2yw","type":"button","click":""});
</script><button class="b24-web-form-popup-btn-8">Забрать животное</button>
    
    <?php
}
add_shortcode('zs_after_post_form', 'zs_after_post_form', 10);