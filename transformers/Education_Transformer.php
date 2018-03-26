<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Education;
    
class Education_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Education $item )
    {
    
        return [
            'id'          => $item->id,
            'employee_id' => $item->employee_id,
            'education'   => $item->education,
            'institute'   => $item->institute,
            'major'       => $item->major,
            'year'        => $item->year,
            'score'       => $item->score,
            'start_date'  => hrm_get_date( $item->start_date ),
            'end_date'    => hrm_get_date( $item->end_date )
        ];

    }
}
