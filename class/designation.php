<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Pagination\Paginator;
use HRM\Models\Designation;
use HRM\Transformers\Designation_Transformer;

class Hrm_Designation {

	use Transformer_Manager;

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function __construct() {
        add_action( 'wp_ajax_hrm_get_designation', array( $this, 'get_designation' ) );
    }

    public function get_designation() {
		check_ajax_referer('hrm_nonce');
    	
		$page         = empty( $_POST['page'] ) ? 1 : intval( $_POST['page'] );
		$per_page     = empty( $_POST['per_page'] ) ? hrm_per_page() : intval( $_POST['per_page'] );

		Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
		$data = Designation::orderBy( 'id', 'DESC' );
        $data = $data->paginate( $per_page );

        $collection = $data->getCollection();

		$resource = new Collection( $collection, new Designation_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $data ) );

        $designation = $this->get_response( $resource );
        wp_send_json_success( $designation );
    }
}