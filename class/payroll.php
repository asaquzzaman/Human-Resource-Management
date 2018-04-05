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
    }

    function ajax_get_formula() {
    	check_ajax_referer('hrm_nonce');

    	$formula = self::getInstance()->get_formula( $_POST );

    	wp_send_json_success( $formula );
    }

    function get_formula( $postData ) {
		$name = empty( $postdata['name'] ) ? false : $postdata['name'];
		$id   = empty( intval( $postdata['id'] ) ) ? false : $postdata['id'];
      

       if ( $id !== false  ) {

            $formual = Formula::find( $id );
            
            if ( $formual ) {
                $resource = new Item( $formual, new Formula_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        $formual = Formula::where( function($q) use( $name ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
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