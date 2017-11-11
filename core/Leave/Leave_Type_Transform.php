<?php
namespace HRM\Core\Leave;

use HRM\Models\Leave_Type;
use League\Fractal\TransformerAbstract;

class Leave_Type_Transform extends TransformerAbstract {
	// protected $defaultIncludes = [
 //        'departments'
 //    ];

	public function transform( Leave_Type $item ) {
		return [
			'id'           => $item->id,
			'name'         => $item->leave_type_name,
			'entitlement'  => $item->entitlement,
			'entitle_from' => $item->entitle_from,
			'entitle_to'   => $item->entitle_to,
			'financial_id' => $item->f_year,
			'next_year'    => $item->carry,
			'departments'  => $item->departments
		];
	}

	// public function includeDepartments( Leave_Type $item ) {
	// 	pr( $item->departments()->get()->toArray() );


	// }
}