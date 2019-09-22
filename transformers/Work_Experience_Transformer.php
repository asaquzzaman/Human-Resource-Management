<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Work_Experience;
    
class Work_Experience_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Work_Experience $item )
    {
    
        return [
            'id'          => $item->id,
            'employee_id' => $item->employee_id,
            'title'       => $item->title,
            'start'       => hrm_get_date( $item->start ),
            'end'         => hrm_get_date( $item->end ),
            'description' => $item->description,
        ];

    }
}
