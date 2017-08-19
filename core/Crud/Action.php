<?php

namespace HRM\Core\Crud;

use HRM\Core\Crud\Pattern;
use HRM\Core\Crud\Validation;

abstract class Action implements Pattern {

	use Validation;

	private $error = array();
	private $postdata = array();
	private $class;
	private $method;

	abstract protected function get_message();
	abstract protected function set_post_data( $postdata );
	abstract protected function get_post_data();
	abstract protected function set_class( $class_name );
	abstract protected function get_class();
	abstract protected function set_method( $method );
	abstract protected function get_method();



	public function create() {
		$validation = $this->create_validation();

		if ( is_wp_error( $validation ) ) {
			$this->error = $validation;
			return false;
		}

		die();
	}

	public function create_validation() {
		$class_name = $this->get_class();
		$use        = "HRM\Models\\$class_name";
		$class      = new $use();
		$post_data  = $this->get_post_data();

		array_walk( $post_data, array( $this, 'filter_post_data' ), $class->create_rules );

	}

	public function filter_post_data( &$val, $key, $rules ) {
		if ( ! array_key_exists( $key, $rules) ) {
			return false;
		}

		//Trait init method for individual field validation
		$this->get_rules( $rules[$key], $val );
	}

}