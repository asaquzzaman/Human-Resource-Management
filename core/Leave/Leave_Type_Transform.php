<?php
namespace HRM\Core\Leave;

use HRM\Models\Leave_Type;
use League\Fractal\TransformerAbstract;

class Leave_Type_Transform extends TransformerAbstract {
	public function transform( Leave_Type $item ) {
		
		return [
			'id'           => $item->id,
			'name'         => $item->leave_type_name,
			'entitlement'  => $item->entitlement,
			'entitle_from' => $item->entitle_from,
			'entitle_to'   => $item->entitle_to,

		];
	}
}