<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Shift;
use HRM\Transformers\Department_Transformer;

class Shift_Transformer extends TransformerAbstract {

    use Resource_Editors;

    protected $defaultIncludes = [
        'departments'
    ];

    public function transform( Shift $item ) {
        
        return [
            'id'            => $item->id,
            'name'          => $item->name,
            'status'        => $item->status,
            'start'         => $item->punch_start,
            'times'         => maybe_unserialize( $item->times ),
            'created_at'    => $item->created_at,
            'updated_at'    => $item->updated_at
        ];
    }

    public function includeDepartments( Shift $item ) {
        $departments = $item->departments()
            ->get();
        
        if ( $departments ) {
            return $this->collection( $departments, new Department_Transformer );
        }

        return null;
    }


}