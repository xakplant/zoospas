# Плагин "Зооспас" (проект для хакатона "Код-на-Амуре)

Плагин для ведения учёта животных и помощи в подборе питомцев для людей.

## Установка

### Из репозитория Wordpress

Скачайте плагин через магазин плагинов Wordpress, установите и активируйте его

### C использованием Git 

Откройте терминал и перейдите в папку с плагинами. Далее введите команду:

```
git clone https://github.com/xakplant/zoospas/archive/master.zip
```

Далее перейдите в админ-панель CMS Wordpress и активируйте плагин "ЗооCпас"

### Из архива

Скачайте архив с плагином по [ссылке](https://github.com/xakplant/zoospas/archive/master.zip). Перейдите в админ панель
CMS Wordpress на страницу "Плагины" > "Добавить новый". Нажмите на кнопку "Загрузить плагин" рядом с заголовком
"Добавить плагины". В появившееся окно вставьте архив с плагином. Далее активируйте плагин.


## Создание карточки животного

В боковом меню CMS WordPress выбирете пункт "Зооспас" > "Добавить животное". 

### Свойства животного

В карточке животного есть как типичные для каждой записи WordPress свойства так и специфические. У каждого животного 
должны быть введены следующие свойства:

+ Заголовок (текст)
+ Описание (текст)
+ Изображение записи (миниатюра)(картинка)
+ Отрывок (краткое описание, текст)
+ Возраст (число)
+ Пол (выбор из списка)
+ Тип (выбор из списка)
+ Размер (текст)

Обратите внимание, что в поле "Возраст" нужно вводить только числа.

## Вывод фильтра животных

Для удобного поиска животных на сайте в плагине есть фильтр. Его можно выводить в любых местах вашего сайта. Для вывода
фильтра предусмотрено два способа. 

### 1. Шорткод

```
[zs_print_filter] //Пишите внутри текстового редактора страниц
```


## Шотркоды 

### Фильтр

```
[zs_print_filter] - выводит фильтр животных на произвольную страницу
```

### Событите
```PHP
do_action('zs_print_filter');
```

после фильтрации отображает список животных блоком с фильтром. 

### Хуки фильтра

Для стилизации фильтра есть несколько хуков. Схематично представить последовательность хуков можно так:

```PHP

do_action('zs_filter_wrap_start', 'data-type="zs_ajaz_form"'); // Оболочка всего фильтра [открыть]

do_action('zs_filter_select_wrap_start', $key); // Оболочка каждого тэга "select" [открыть]

do_action('zs_filter_select_wrap_end'); // Оболочка каждого тэга "select" [закрыть]

do_action('zs_filter_print_button', 'data-type="zs_ajax_btn"'); // Кнопка "отфильтровать"

do_action('zs_filter_wrap_end'); // Оболочка всего фильтра [закрыть]
```

#### zs_filter_wrap_start

У фильтра есть оболочка, которую можно менять. Хук zs_filter_wrap_start печатает на страницу открывающий тэг этой 
"оболочки". У данного хука есть принимаемый параметр, который обязательно нужно распечатать. Пример кода:

```PHP
remove_action('zs_filter_wrap_start', 'zs_filter_wrap_start', 10);
add_action('zs_filter_wrap_start', 'zss_filter_wrap_start', 10, 1);
function zss_filter_wrap_start($zs_attribute){
    echo '<div class="choice_wp flex" ' . $zs_attribute . '>';
}
```

#### zs_filter_wrap_end

zs_filter_wrap_end печатает на страницу закрывающий тэг для оболочки фильтра. Пример кода:

```PHP
remove_action('zs_filter_wrap_end', 'zs_filter_wrap_end', 10);
add_action('zs_filter_wrap_end', 'zss_filter_wrap_end', 10, 1);
function zss_filter_wrap_end(){
    echo '</div>';
}
```

#### zs_filter_select_wrap_start

zs_filter_select_wrap_start печатает на страницу открыввающий тэг для обёртки тэга "select" в фильтре. Пример кода:

```PHP
remove_action('zs_filter_select_wrap_start', 'zs_filter_select_wrap_start', 10);
add_action('zs_filter_select_wrap_start', 'zss_filter_select_wrap_start', 10, 1);
function zss_filter_select_wrap_start($key){
    echo '<div class="choice_block"><div class="choice_select">';
}
```

Хук принимает переменную $key, значение которой равно названию meta-поля "meta key". Его использование необязательно, но
если вам нужно будет, например, стилистически подчеркнуть определённое поле, вы можете использовать эту переменную. 

#### zs_filter_select_wrap_end

zs_filter_select_wrap_end печатает закрывающий тэг для обёртки тэга "select" в фильтре. Пример кода:

```PHP
remove_action('zs_filter_select_wrap_end', 'zs_filter_select_wrap_end', 10);
add_action('zs_filter_select_wrap_end', 'zss_filter_select_wrap_end', 10);
function zss_filter_select_wrap_end(){
    echo '</div></div>';
}
```

#### zs_filter_print_button

zs_filter_print_button печатает в фильтре кнопку "фильтровать". Принимает обязательный параметр, который должен быть 
распечатан внутри кнопки, как атрибут. Пример кода:

```PHP
remove_action('zs_filter_print_button', 'zs_filter_print_button', 10);
add_action('zs_filter_print_button', 'zss_filter_print_button', 10, 1);
function zss_filter_print_button($zs_attribute){
    echo '<div class="choice_block cb_mob">';
    echo '<a ' . $zs_attribute . ' class="button button_h1 choice_btn btn-zs-default">Найти</a>';
    echo '</div>';
}
```

### Хуки карточки животного

В результатах фильтра выводится список животных. Схему хуков печати карточки животных можно представить так:

```PHP

// Оболочка [открыть]
do_action('zs_card_wraper_start');

// Заголовок
do_action('zs_card_title');

// Короткое описание
do_action('zs_card_excerpt');

// Мета данные
do_action('zs_card_meta');

// Картинка
do_action('zs_card_thumbnail');

// Полное описание
 do_action('zs_card_content');

 // Кнопка редактировать, отображается только от администратора
do_action('zs_admin_edit_post');

// Оболочка [закрыть]
do_action('zs_card_wraper_end');

```
#### zs_card_wraper_start

zs_card_wraper_start печатает открывающий тэг оболочки карточки животного. Пример кода:

```PHP
remove_action( 'zs_card_wraper_start', 'zs_card_wraper_start', 20);
add_action('zs_card_wraper_start', 'zss_card_wraper_start', 10);
function zss_card_wraper_start(){
    echo '<div class="catalog_item row align-items-center">';
}
```


#### zs_card_wraper_end

zs_card_wraper_end печатает закрывающий тэг оболочки карточки животного. Пример кода:

```PHP
remove_action( 'zs_card_wraper_end', 'zs_card_wraper_end', 20);
add_action('zs_card_wraper_end', 'zss_card_wraper_end');
function zss_card_wraper_end(){
    echo '</div>';
}
```

#### zs_card_title

zs_card_title печатает заголовок карточки животного

```PHP
remove_action( 'zs_card_title', 'zs_card_title', 20);
add_action( 'zs_card_title', 'zss_card_title', 20);
function zss_card_title(){
    the_title('<h2>', '</h2>');
}
```

#### zs_card_excerpt

zs_card_excerpt печатает краткое описание животного. Пример кода:
```PHP
remove_action('zs_card_excerpt', 'zss_card_excerpt', 20);
add_action('zs_card_excerpt', 'zss_card_excerpt', 20);
function zss_card_excerpt(){
    the_excerpt();
}
```

#### zs_card_meta
zs_card_meta печатает мета данные животного из плагина ЗооСпас. Пример кода:

```PHP
remove_action('zs_card_meta', 'zs_card_meta', 20);
add_action('zs_card_meta', 'zss_card_meta', 20);
function zss_card_meta(){
    $arrKeys = ZoospasFilter::zs_get_meta_key();
    $alias = zs_get_meta_key_alias();
    
    echo '<table><tbody>';
    
    foreach($arrKeys as $key){
        echo '<tr><td>' . $alias[$key] . '</td><td>' . get_post_custom_values( $key, $post->ID ) . '</td></tr>';
        // $post->ID доступен так как собывие выполнятся внутри цикла worpress
    }
    
    echo '</tbody></table>';
}
```

#### zs_card_thumbnail

zs_card_thumbnail печатает миниатюру карточки животного в результатах фильтра. Пример кода:

```PHP
remove_action('zs_card_thumbnail', 'zs_card_thumbnail', 20);
add_action('zs_card_thumbnail', 'zss_card_thumbnail', 20);
/**
* Функция проверяет есть ли миниатюра записи и печатает её в случае если она есть или
* печатает картинку по умолчаниею если миниатюры нет. get_template_directory_uri() - директория с текущей темой
*/
function zs_card_thumbnail(){

    echo '<div class="ci_img col-lg-5">';
    $thumb = get_the_post_thumbnail( $post->ID, array('410', '390'), null );
    if(!empty($thumb)){
        echo $thumb;
    } else {
        echo '<img src="'. get_template_directory_uri() .'/images/thumb.jpg" />';
    }
    echo '</div>';

}
```

#### zs_card_content

zs_card_content печатает описание животного в результатах фильтра. Пример кода:

```PHP
remove_action('zs_card_content', 'zs_card_content', 20);
add_action('zs_card_content', 'zss_card_content', 20);
function zss_card_content(){
echo '<div class="wrap">';
    the_content();
echo '<div>';
}
```

#### zs_admin_edit_post

zs_admin_edit_post печатает ссылку на страницу редактирования (видно только администратору). Пример кода:

```PHP
remove_action('zs_admin_edit_post', 'zs_admin_edit_post');
add_action('zs_admin_edit_post', 'zss_admin_edit_post');
function zss_admin_edit_post($settings = null){
    if(is_admin()){
        if($settings){

            echo '<a ';
            zs_attr_printer($settings);
            echo 'href="/wp-admin/post.php?post='. get_the_ID() .'&amp;action=edit">'.__('Edit', 'zoospas') .'</a>';;
        }
        else {

            echo '<a href="/wp-admin/post.php?post='. get_the_ID() .'&amp;action=edit">'.__('Edit', 'zoospas') .'</a>';

        }
    }
}
```

### CSS-стили карточки в фильтре

```CSS
.zs_card{} /* Стиль обёртки карточки животного в фильтре */

.zs_card .table.table-default{} /* Стиль таблицы с мета-данными */
```

## Вывод карточки животного

На странице карточки животного можно вывести данные животного шорткодом: 

```PHP
[zs_print_pet_card]
```

Хотя это быстро и удобно, лучше сделать специальный шаблон для типа записи zs_pets. Для этого создайте 
в директории вашей темы файл с именем single-zs_pets.php и напишите свой код. Пример кода:

```PHP

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package template_name
 */

get_header();


?>
    <div class="container">
     
     <?php
         while ( have_posts() ) :
             the_post();

             the_title('<h1>', '</h1>');
            
             the_content();
             
            echo get_the_post_thumbnail( $id, array('410', '410'), null );
            
            do_action('zs_card_meta');

         endwhile; // End of the loop.
     ?>
     
    </div>  

<?php
get_footer();

```

## Кнопки целевых действий

В плагине вы можете создать две универсальные ссылки на страницы с важной информацией. У каждой кнопки есть следующие
настройки:

+ текст кнопки
+ css-класс
+ ссылка
+ id

Чтобы их настроить, нужно перейти на страницу "ЗооСпас" > "Настройки" из админ-панели WordPress. В плагине данные кнопки
условно различаются на "левую" и "правую". Шорткоды соответственно:

```PHP
[zs_button_left]
[zs_button_right]
```

Точно также их можно вызвать событиями:

```PHP
do_action('zs_button_left');
do_action('zs_button_right');
```

Их ститистическое отображение будет полностью зависет от стилей оформления ссылок в теме и настроек в админ-панеле.

### Форма обратной связи

В плагине предусмотрена "легковесная" форма обратной связи с различными типами отображения, благодаря которому 
она превращается в универсальный инструмент. Вызывается шорткодом:

```PHP
[zs_form]
```

или событием:
```PHP
do_action('zs_form');
```

#### Настройки универсального блока

Данный блок имеет настройки:

+ Электронная почта для отправки писем
+ Тип
+ Класс формы
+ Текст кнопки
+ Класс кнопки
+ html id кнопки
+ ссылка
+ JavaScript

Самым важным параметром является "Тип". Варинаты типов: 

+ JavaScript
+ Ссылка
+ Форм
+ Всплывающее окно

#### JavaScript

JavaScript выводит на страницу HTML, где находится шорткод. Данный вариант вам будет полезен в случае, если вам нужно
вывести форму с внешнего сервиса, например, битрикс24 формы. 

HTML задаётся в пункте "JavaScript" раздела настроек "Настройки формы обратной связи".

#### Ссылка

Выводит ссылку на страницу. URL задаётся в поле "Ссылка" раздела настроек "Настройки формы обратной связи".

#### Форма

При данном типе на страницу выводится форма обратной связи. Для формы вы можете дополнительно задать css-класс.

#### Модальное окно

Выводит на страницу кнопку, которая вызывает всплывающее окно с формой обратной связи. 


## Создание шаблона страницы для вывода списка животных

Создайте страницу в админ-панеле WordPress и разместите на ней шорткод:

```
[zs_pets_list]
```

Если вам нужно вывести какой-то конкретный тип записи, то шорткод будет выглядеть так:

```
[zs_pets_list type="Cat" ]
```

Всего доступно 3 типа:

+ Cat (кошки)
+ Dog (собаки)
+ Other (другие животные)

Вы можете пойти другим путём и создать шаблон для списка животных. Пример кода:

```PHP
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package template_name
 * Template Name: Список животных
 */

get_header();

$calc = get_option( 'posts_per_page' );
$paged = $GLOBALS['wp_query']->query_vars['paged'];
if($paged){
    $offset = $calc * ($paged - 1);
} else {
    $offset = 0;
}
$new_query = new WP_Query(array('post_type'=>'zs_pets', 'offset'=>$offset));
?>
>
    <div class="screen_2 catalog_s2">
        <div class="container">
            <p class="title"><?php echo single_post_title(); ?></p>
            <?php do_shortcode('[zs_print_filter]'); ?>
        </div>
    </div>

        <div class="container">

            <?php while ( $new_query->have_posts() ) :
                $new_query->the_post();

                get_template_part( 'template-parts/content', 'pets' );

            endwhile;

            $GLOBALS['wp_query']->max_num_pages = $new_query->max_num_pages;
            the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Previous page', 'zoospas' ), 'next_text' => __( 'Next page', 'zoospas' ), 'screen_reader_text' => __( 'Posts navigation' ) ) );

            ?>
        </div>


<?php
get_footer();
```


## Функции  

### Массив с именами zs_get_meta_key_alias()

Возвращает массив:

```
[
    '_zs_age'=> __('Age', 'zoospas'),
    '_zs_sex'=> __('Sex', 'zoospas'),
    '_zs_size'=> __('Size', 'zoospas'),
    '_zs_pet_type'=> __('Type of pets', 'zoospas'),
];
```
