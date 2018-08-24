<?php

/**
 * Created by PhpStorm.
 * User: Cherepanov
 * Date: 24.08.2018
 * Time: 14:15
 */
class Example_List_Table extends WP_List_Table
{
    function __construct(){
        parent::__construct(array(
            'singular' => 'log',
            'plural'   => 'logs',
            'ajax'     => false,
        ));

        $this->bulk_action_handler();

        // screen option
        add_screen_option( 'per_page', array(
            'label'   => 'Показывать на странице',
            'default' => 20,
            'option'  => 'logs_per_page',
        ) );

        $this->prepare_items();

        add_action( 'wp_print_scripts', [ __CLASS__, '_list_table_css' ] );
    }

    // создает элементы таблицы
    function prepare_items(){
        global $wpdb;

        // пагинация
        $per_page = get_user_meta( get_current_user_id(), get_current_screen()->get_option( 'per_page', 'option' ), true ) ?: 20;

        $this->set_pagination_args( array(
            'total_items' => 3,
            'per_page'    => $per_page,
        ) );
        $cur_page = (int) $this->get_pagenum(); // желательно после set_pagination_args()

        // элементы таблицы
        // обычно элементы получаются из БД запросом
        // $this->items = get_posts();

        // чтобы понимать как должны выглядеть добавляемые элементы
        $this->items = array(
            array(
                'id'   => 2,
                'key'  => 'aaaaaaaaaa777777',
                'name' => 'Коля',
            ),
            array(
                'id'   => 3,
                'key'  => 'ddddddd555555555',
                'name' => 'Витя',
            ),
            array(
                'id'   => 4,
                'key'  => 'hhhhhhhhhhh999999',
                'name' => 'Петя',
            ),
        );

    }

    // колонки таблицы
/*    function get_columns(){
        return array(
            'cb'            => '<input type="checkbox" />',
            'id'            => 'ID',
            'customer_name' => 'Имя',
            'license_key'   => 'License Key',
        );
    }*/

    function get_columns(){
        return array(
            'cb'=>'<input type="checkbox" />',
            'id'=>'ID',
            'custumer_name'=>'Name',
            'license_key'=>'KEy',
        );
    }

    // сортируемые колонки
    function get_sortable_columns(){
        return array(
            'customer_name' => array( 'name', 'desc' ),
        );
    }

    protected function get_bulk_actions() {
        return array(
            'delete' => 'Delete',
        );
    }

    // Элементы управления таблицей. Расположены между групповыми действиями и панагией.
    function extra_tablenav( $which ){
        echo '<div class="alignleft actions">HTML код полей формы (select). Внутри тега form...</div>';
    }

    // вывод каждой ячейки таблицы -------------

    static function _list_table_css(){
        ?>
        <style>
            table.logs .column-id{ width:2em; }
            table.logs .column-license_key{ width:8em; }
            table.logs .column-customer_name{ width:15%; }
        </style>
        <?php
    }

    // вывод каждой ячейки таблицы...
    function column_default( $item, $colname ){

        if( $colname === 'customer_name' ){
            // ссылки действия над элементом
            $actions = array();
            $actions['edit'] = sprintf( '<a href="%s">%s</a>', '#', __('edit','hb-users') );

            return esc_html( $item->name ) . $this->row_actions( $actions );
        }
        else {
            return isset($item->$colname) ? $item->$colname : print_r($item, 1);
        }

    }

    // заполнение колонки cb
    function column_cb( $item ){
        echo '<input type="checkbox" name="licids[]" id="cb-select-'. $item->id .'" value="'. $item->id .'" />';
    }

    // остальные методы, в частности вывод каждой ячейки таблицы...

    // helpers -------------

    private function bulk_action_handler(){
        if( empty($_POST['licids']) || empty($_POST['_wpnonce']) ) return;

        if ( ! $action = $this->current_action() ) return;

        if( ! wp_verify_nonce( $_POST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) )
            wp_die('nonce error');

        // делает что-то...
        die( $action ); // delete
        die( print_r($_POST['licids']) );

    }

    // Пример создания действий - ссылок в основной ячейки таблицы при наведении на ряд.
    // Однако гораздо удобнее указать их напрямую при выводе ячейки - см ячейку customer_name...

    // основная колонка в которой будут показываться действия с элементом
    protected function get_default_primary_column_name() {
        return 'disp_name';
    }

    // действия над элементом для основной колонки (ссылки)
    protected function handle_row_actions( $post, $column_name, $primary ) {
        if ( $primary !== $column_name ) return ''; // только для одной ячейки

        $actions = array();

        $actions['edit'] = sprintf( '<a href="%s">%s</a>', '#', __('edit','hb-users') );

        return $this->row_actions( $actions );
    }

    public function display_rows(){

        foreach( $this->items as $item ) $this->single_row( $item );

    }
    public function display(){

        $singular = $this->_args['singular'];

        $this->display_tablenav( 'top' );

        $this->screen->render_screen_reader_content( 'heading_list' );
        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
            <thead>
            <tr>
                <?php $this->print_column_headers(); ?>
            </tr>
            </thead>

            <tbody data-rabotaet id="the-list"<?php
            if ( $singular ) {
                echo " data-wp-lists='list:$singular'";
            } ?>>
            <?php $this->display_rows_or_placeholder(); ?>

            <?php

          /*      print_r($this->items);*/

            ?>

            </tbody>

            <tfoot>
            <tr>
                <?php $this->print_column_headers( false ); ?>
            </tr>
            </tfoot>

        </table>
        <?php
        $this->display_tablenav( 'bottom' );

    }



    public function display_rows_or_placeholder() {
        if ( $this->has_items() ) {
            $this->display_rows();
        } else {
            echo '<tr class="no-items"><td class="colspanchange" colspan="' . $this->get_column_count() . '">';
            $this->no_items();
            echo '</td></tr>';
        }
    }


}