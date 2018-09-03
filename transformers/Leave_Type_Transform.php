<?php
namespace HRM\Transformers;

use HRM\Models\Leave_Type;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as Collection;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use HRM\Transformers\Department_Transformer;

class Leave_Type_Transform extends TransformerAbstract {
	use Transformer_Manager, Resource_Editors;

	protected $defaultIncludes = [
        'departments'
    ];

	public function transform( Leave_Type $item ) {
		return [
			'id'           => $item->id,
			'name'         => $item->leave_type_name,
			'entitlement'  => $item->entitlement,
			'entitle_from' => $item->entitle_from,
			'entitle_to'   => $item->entitle_to,
			'financial_id' => $item->f_year,
			'next_year'    => $item->carry,
		];
	}

	public function includeDepartments( Leave_Type $item ) {
		$departments = $item->departments;
		$resource = new Collection( $departments, new Department_Transformer );

		return $resource;
	}
}