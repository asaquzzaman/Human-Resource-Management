<?php

namespace HRM\Core\Crud;

trait Validation {
	public function get_rules( $rules, $value ) {
		var_dump( $this->error, $value, $rules ); 
	}
}