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
	public function set_post_data() {
		$this->postdata = [];
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


	public static function ajax_data_process() {
		check_ajax_referer('hrm_nonce');
		
		$success = self::data_process();

		if ( is_wp_error( $success ) ) {
			wp_send_json_error( array(
				'error' => $success->get_error_messages()
			));
		}

		wp_send_json_success(array(
			'success' => __( 'Successfully updated', 'hrm' )
		));
	}

	public static function data_process() {

		$class  = isset( $_POST['class'] ) ? hrm_clean( $_POST['class'] ) : '';
		$method = isset( $_POST['method'] ) ? hrm_clean( $_POST['method'] ) : '';
		$self   = self::getInstance();

		$self->set_post_data();
		$self->set_class( $class );
		$self->set_method( $method );
		
		return $self->$method();
	}
}