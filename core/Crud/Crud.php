<?php
namespace HRM\Core\Crud;

use HRM\Core\Crud\Action;

class Crud extends Action {
	private static $_instance;
	
	public static function getInstance() {
		if( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Set form submited data
	 * 
	 * @param array $postdata 
	 *
	 * @return  void
	 */
	public function set_post_data( $postdata ) {
		$this->postdata = $postdata;
	}

	/**
	 * Get form submited data
	 *
	 * @return  array()
	 */
	public function get_post_data() {
		return $this->postdata;
	}

	/**
	 * Set class name
	 * 
	 * @param string $class_name 
	 *
	 * @return  void
	 */
	public function set_class( $class_name ) {
		$this->class = $class_name;
	}

	/**
	 * Get class name
	 *
	 * @return  string
	 */
	public function get_class() {
		return $this->class;
	}

	/**
	 * Set method
	 * 
	 * @param string $method 
	 *
	 * @return  void
	 */
	public function set_method( $method ) {
		$this->method = $method;
	}

	/**
	 * Get method
	 *
	 * @return  string
	 */
	public function get_method() {
		return $this->method;
	}


	public function get_message() {
		return $this->error;
	}

	public static function ajax_data_process() {
		check_ajax_referer('hrm_nonce');

		$class  = isset( $_POST['class'] ) ? $_POST['class'] : '';
		$method = isset( $_POST['method'] ) ? $_POST['method'] : '';
		$self   = self::getInstance();

		$self->set_post_data( $_POST );
		$self->set_class( $class );
		$self->set_method( $method );
		
		$self->$method();

		$message = $self->get_message();
		var_dump( $message ); die();
		wp_send_json_success( array(
			'error' => $message
		) );
	}
}