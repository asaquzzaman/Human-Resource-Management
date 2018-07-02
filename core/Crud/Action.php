<?php

namespace HRM\Core\Crud;

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Crud\Pattern;
//use HRM\Core\Crud\Validation;
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Pagination\Paginator;

abstract class Action implements Pattern {

	use Transformer_Manager;

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
		$per_page     = empty( $postdata['per_page'] ) ? hrm_per_page() : $postdata['per_page'];

		Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
		$data = $model::orderBy( 'id', 'DESC' );
        $data = apply_filters( 'before_'. $model->getTableName().'_get', $data, $postdata );
        $data = $data->paginate( $per_page );

        $collection = $data->getCollection();

		$resource = new Collection( $collection, new $transformers );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $data ) );

        return $this->get_response( $resource );
	}
	public function show() {
		$model        = $this->get_model();
		$postdata     = $this->get_post_data();
		$id           = (int) $postdata['id'];
		$transformers = $postdata['transformers'];
		$transformers = "HRM\\Transformers\\$transformers";


		$data = $model::where('id', $id);
        $data = apply_filters( 'before_'. $model->getTableName().'_show', $data, $postdata );
        $data = $data->first();
		$resource = new Item( $data, new $transformers );
        return $this->get_response( $resource );
	}
	public function create() {
		// $this->create_validation();

		// if ( is_wp_error( $this->error ) ) {
		// 	return $this->error;
		// }

		$model        = $this->get_model();
		$postdata     = $this->get_post_data();	
		$postdata     = method_exists($model, 'sanitize') ? $model::sanitize( $postdata ) : $postdata;
		$transformers = $postdata['transformers'];
		$transformers = "HRM\\Transformers\\$transformers";
		
		$crated = $model::create( $postdata );

		$crated = apply_filters( 'after_'. $model->getTableName().'_create', $crated, $postdata );
		
		$resource  = new Item( $crated, new $transformers );

        $message = [
            'message' => 'Record has been save successfully!'
        ];

        return $this->get_response( $resource, $message );
	}

	public function create_validation() {
		$class = $this->get_model();

		if ( empty( $class->validation_rules ) ) {
			return true;
		}
		
		array_walk( $class->validation_rules, array( $this, 'filter_post_data' ) );
	}

	public function filter_post_data( $rules, $name ) {
		$postdata = $this->get_post_data();

		//Trait init method for individual field validation
		$this->get_rules( $postdata, $name, $rules );

		//set default data for individual field
		$this->set_post_data( $this->postdata );
	}

	public function update() {
		$model       = $this->get_model();
		$postdata    = $this->get_post_data();
		$postdata     = method_exists($model, 'sanitize') ? $model::sanitize( $postdata ) : $postdata;
		$fillable    = $model->getFillable();
		$transformers = $postdata['transformers'];
		$transformers = "HRM\\Transformers\\$transformers";
		$update_data = [];
		$record      = $model::where( 'id', $postdata['id'] )->first();

		$postdata = apply_filters( 'before_'. $model->getTableName().'_update', $postdata );

		if ( $record ) {
			foreach ( $postdata as $key => $value ) {
	            if ( in_array( $key, $fillable ) ) {
	                $update_data[$key] = $value;
	            }
	        }

			$record->update( $update_data );
			
			$record = apply_filters( 'after_'. $model->getTableName().'_update', $record, $postdata );

			$resource = new Item( $record, new $transformers );

	        $message = [
	            'message' => 'Has been updated successfully!'
	        ];

	        return $this->get_response( $resource, $message );
		}
		
		return false;
	}

	public function delete() {
		$model    = $this->get_model();
		$postdata = $this->get_post_data();
		$delete   = $postdata['delete'];

		$Object =  $model::whereIn( 'id', $delete );
		$Object = apply_filters( 'before_'. $model->getTableName().'_delete', $Object,  $postdata );

	    $Object->delete();

	    $message = [
            'message' => 'Delete successfully!'
        ];

        return $this->get_response( null, $message );
	}

	private function get_model() {
		$class_name = $this->get_class();
		$use        = "HRM\\Models\\$class_name";
		
		return new $use();
	}
}

