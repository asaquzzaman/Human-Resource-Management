<?php

namespace HRM\Core\Crud;

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Crud\Pattern;
use HRM\Core\Crud\Validation;
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

abstract class Action implements Pattern {

	use Validation, Transformer_Manager;

	private $postdata = array();
	private $class;
	private $method;

	abstract protected function set_post_data( $postdata );
	abstract protected function get_post_data();
	abstract protected function set_class( $class_name );
	abstract protected function get_class();
	abstract protected function set_method( $method );
	abstract protected function get_method();

	public function gets() {
		$model        = $this->get_model();
		$postdata     = $this->get_post_data();
		$page         = empty( $postdata['page'] ) ? 1 : intval( $postdata['page'] );
		$transformers = $postdata['transformers'];
		$transformers = "HRM\\Transformers\\$transformers";
		$per_page     = 15;

		$data = $model::orderBy( 'id', 'DESC' )
            ->paginate( $per_page, ['*'], 'page', $page );

        $collection = $data->getCollection();

		$resource = new Collection( $collection, new $transformers );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $data ) );

        return $this->get_response( $resource );
	}

	public function create() {
		$this->create_validation();

		if ( is_wp_error( $this->error ) ) {
			return $this->error;
		}

		$model 		= $this->get_model();
		$postdata   = $this->get_post_data();	
		
		return $model::create( $postdata );
	}

	public function create_validation() {
		$class = $this->get_model();
		
		array_walk( $class->validation_rules, array( $this, 'filter_post_data' ) );
	}

	public function filter_post_data( $rules, $name ) {
		$postdata   = $this->get_post_data();

		//Trait init method for individual field validation
		$this->get_rules( $postdata, $name, $rules );

		//set default data for individual field
		$this->set_post_data( $this->postdata );
	}

	public function update() {
		$model       = $this->get_model();
		$postdata    = $this->get_post_data();	
		$fillable    = $model->getFillable();
		$update_data = [];
		$record      = $model::where( 'id', $postdata['id'] )->first();

		if ( $record ) {
			foreach ( $postdata as $key => $value ) {
	            if ( in_array( $key, $fillable ) ) {
	                $update_data[$key] = $value;
	            }
	        }

			$record->update( $update_data );

			return $model::find( $postdata['id'] )->toArray();
		}
		
		return false;
	}

	private function get_model() {
		$class_name = $this->get_class();
		$use        = "HRM\\Models\\$class_name";
		
		return new $use();
	}
}

