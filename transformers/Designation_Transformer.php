<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Designation;
use HRM\Transformers\Department_Transformer;
    
class Designation_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

   	protected $defaultIncludes = [
        'department'
    ];

    public function transform( Designation $item ) {
    
        return [
            'id'          => $item->id,
            'title'       => $item->title,
            'description' => $item->description,
        ];

    }

    public function includeDepartment( Designation $item ) {
        $department = $item->dept()->first();

        if ( $department ) {
            return $this->item( $department, new Department_Transformer );
        }

        return null;
    }
}
