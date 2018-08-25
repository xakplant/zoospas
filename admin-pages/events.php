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

function zs_pet_list(){
    ?>

        <p>Контент для Списка животных</p>

    <?php
}


function zs_admin_panel(){
    
    echo '<h2>Настройки</h2>';
    
    ?>
    
    <form name="zs_options" method="post">
        <label>Оснавная категория по которой плагин будет понимать что запись о животном</label>
        <input type="text" name="zs_pr_category" value="pet"/><br>
        <label>Категория с типом животного (например, кошки или cat</label>
        <input type="text" name="zs_pr_second_0" value="cat"/><br>
        <label>Категория с типом животного (например, собаки или dog</label>
        <input type="text" name="zs_pr_second_1" value="dog"/><br>
        <label>Категория с типом животного (например, прочие, прички и т.д.t</label>
        <input type="text" name="zs_pr_second_2" value="other"/><br>
        <button type="submit">сохранить настройки</button>
    </form>
    
    
    <?php
    
}
