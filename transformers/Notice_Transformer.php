<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Notice;
    
class Notice_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

   	protected $defaultIncludes = [
        
    ];

    public function transform( Notice $item ) {
    
        return [
            'id'          => $item->id,
            'title'       => $item->title,
            'description' => $item->description,
            'date'        => hrm_get_date( $item->date ),
        ];

    }
}
