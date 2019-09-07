<?php

namespace HRM\Core\Crud;

interface Pattern {
	public function create();

//	public function create_validation();

	public function update();

	public function gets();

	public function delete();
	
}