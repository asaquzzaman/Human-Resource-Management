<?php

namespace HRM\Core\Crud;

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Crud\Pattern;
use HRM\Core\Crud\Validation;

abstract class Action implements Pattern {

	use Validation;

	private $postdata = array();
	private $class;
	private $method;

	abstract protected function set_post_data( $postdata );
	abstract protected function get_post_data();
	abstract protected function set_class( $class_name );
	abstract protected function get_class();
	abstract protected function set_method( $method );
	abstract protected function get_method();


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
		
		array_walk( $class->create_rules, array( $this, 'filter_post_data' ) );
	}

	public function filter_post_data( $rules, $name ) {
		$postdata   = $this->get_post_data();

		//Trait init method for individual field validation
		$this->get_rules( $postdata, $name, $rules );

		//set default data for individual field
		$this->set_post_data( $this->postdata );
	}

	private function get_model() {
		$class_name = $this->get_class();
		$use        = "HRM\Models\\$class_name";
		
		return new $use();
	}
}

