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
            'id'        => $item->id,
            'level'     => $item->level,
            'institute' => $item->institute,
            'major'     => $item->major,
            'gpa'       => $item->gpa,
            'start'     => $item->start,
            'end'       => $item->end
        ];

    }
}
