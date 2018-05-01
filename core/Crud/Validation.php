<?php

namespace HRM\Core\Crud;

trait Validation {
	public $error;

	private $default_message;
	private $value;
	private $name;
	private $postdata = array();

	/**
	 * Initial function of this object
	 * 
	 * @param  array $postdata   
	 * @param  string $field_name 
	 * @param  array $rules      
	 *
	 * @return  void 
	 */
	public function get_rules( $postdata, $field_name, $rules ) {
		$this->value           = isset( $postdata[$field_name] ) ? trim( $postdata[$field_name] ) : '';
		$this->default_message = empty( $rules['message'] ) ? '' : $rules['message'];
		$this->name            = $field_name;
		$this->postdata        = $postdata;

		$types = explode( '|', $rules['type'] ); 

		array_walk( $types, array( $this, 'call_method' ) );
	}

	/**
	 * Set error
	 * 
	 * @param string $code    
	 * @param string $message 
	 * @param mixed $data   
	 *
	 * @return  void
	 */
	public function set_error( $code, $message, $data = '' ) {
		if ( ! $this->error ) {
			$this->error = new \WP_Error();
		}

		$this->error->add( $code, $message, $data );
	}

	/**
	 * Call validation individual method
	 * 
	 * @param  string $method 
	 * @param  int $key    
	 *
	 * @return  voie
	 */
	function call_method( $method, $key ) {
		$find     = strpos( $method, ':' );

		if ( $find !== false  ) {
			$this->param_vaidation( $method );
		
		} else {
			$this->$method();
		}
	}

	/**
	 * Call individual validation methon, which method need params
	 * 
	 * @param  string $method 
	 * 
	 * @return void        
	 */
	public function param_vaidation( $method ) {
		$expand = explode( ':', $method );
		$method = $expand[0];
		$param  = explode( ',', $expand[1] );

		$this->$method( $param );
	}

	function range( $args ) {
		
	}

	function required() {
		$value   = $this->value;
		$message = $this->default_message['required'];
		$name    = $this->name;
		
		if( ! trim( $value ) ) {
			$this->set_error( $name, $message );
		}
	}

	function email() {
		
	}

	function defaults( $arg ) {
		$value 			 = array_shift( $arg );
		$postdata        = $this->postdata;
		$name            = $this->name;
		$postdata[$name] = empty( $postdata[$name] ) ? $value : $postdata[$name];
		$this->postdata  = $postdata;
	}

	function relational_required( $args ) {
		$field       = $args[0];
		$compare_val = $args[1];

		if ( 
			isset( $this->postdata[$field] ) 
			&& 
			( $this->postdata[$field] === $compare_val )
		) {
			$this->required();
		}  
	}
}

