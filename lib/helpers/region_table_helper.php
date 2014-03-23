<?php
namespace Huiskamers;
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class RegionTableHelper extends \WP_List_Table {
    private $controller = NULL;
    private $model_name = NULL;
    function __construct($controller, $model_name){
        global $status, $page;
        $this->controller = $controller;
        $this->model_name = $model_name;
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'regio',     //singular name of the listed records
            'plural'    => 'regio\'s',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
        return $item->$column_name();  
    }

    function column_title($item){
        //Build row actions
        $actions = array(

            'edit'      => '<a href=\'' . $this->controller->url('edit', $item->id()) . '\'>Edit</a>',
            'delete'    => '<a href=\'' . $this->controller->url('delete', $item->id()) . '\'>Delete</a>',
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item->name(),
            /*$2%s*/ $item->id(),
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item->id()              //The value of the checkbox should be the record's id
        );
    }


    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'title'     => 'Naam',
            'created_at'    => 'Gemaakt',
            'updated_at'  => 'Bewerkt'
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', true), 
            'title'     => array('name',false),     //true means it's already sorted
            'created_at'    => array('created_at',false),
            'updated_at'  => array('updated_at',false)
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Verwijder'
        );
        return $actions;
    }

    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            $regio_ids = $_REQUEST['regio'];
            Region::delete_bulk($regio_ids);
        }
    }

    function prepare_items() {
        $per_page = 5;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        $this->process_bulk_action();
        
        
        $order_by = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to title
        $order_direction = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
        $order = "$order_by $order_direction";
        $where = '1=1';

        
        $current_page = $this->get_pagenum();
        $model_name = $this->model_name;
        $total_items = $model_name::count($where);
        $this->items = $model_name::where($where, $order, $current_page, $per_page);
        
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
?>