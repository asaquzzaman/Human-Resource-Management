<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Formula;
use HRM\Transformers\Formula_Transformer;

class Hrm_Payroll {
    use Transformer_Manager;

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function __construct() {
        add_action( 'wp_ajax_hrm_get_formula', array( $this, 'ajax_get_formula' ) );
        add_action( 'wp_ajax_hrm_update_formula', array( $this, 'ajax_update_formula' ) );
        add_action( 'wp_ajax_hrm_delete_formula', array( $this, 'ajax_delete_formula' ) );
    }

    function ajax_update_formula() {
        check_ajax_referer('hrm_nonce');
        $formula = self::getInstance()->update_formula( $_POST );

        wp_send_json_success( $formula );
    }

    function ajax_delete_formula() {
        check_ajax_referer('hrm_nonce');
        
        self::getInstance()->delete_formula( $_POST['delete'] );
        wp_send_json_success();
    }

    function delete_formula( $formula_ids ) {
        foreach ( $formula_ids as $key => $formula_id ) {
             $update = array(
                'class'        => 'Formula',
                'method'       => 'update',
                'transformers' => 'Formula_Transformer',
                'status'       => 'disable',
                'id'           => $formula_id
            );

            hrm_update_records( $update );
        }
    }

    function update_formula( $postdata ) {
        
        $update = array(
            'class'        => 'Formula',
            'method'       => 'update',
            'transformers' => 'Formula_Transformer',
            'status'       => 'disable',
            'id'           => empty( intval( $postdata[id] ) ) ? false : intval( $postdata[id] )
        );

        hrm_update_records( $update );

        $postdata['method'] =  'create';
        unset( $postdata['id'] );

        return hrm_insert_records( $postdata );
    }

    function ajax_get_formula() {
    	check_ajax_referer('hrm_nonce');

    	$formula = self::getInstance()->get_formula( $_POST );

    	wp_send_json_success( $formula );
    }

    function get_formula( $postData ) {
		$name = empty( $postdata['name'] ) ? false : $postdata['name'];
		$id   = empty( intval( $postdata['id'] ) ) ? false : $postdata['id'];
        $status = 'enable';
      

       if ( $id !== false  ) {

            $formual = Formula::find( $id );
            
            if ( $formual ) {
                $resource = new Item( $formual, new Formula_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        $formual = Formula::where( function($q) use( $name, $status ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
            }
            if ( ! empty(  $status ) ) {
                $q->where( 'status', $status );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page, ['*'], 'page', $page );
    
        $collection = $formual->getCollection();

        $resource = new Collection( $collection, new Formula_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $formual ) );

        return $this->get_response( $resource );
    }	
}