<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use HRM\Models\Department;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
    
class Department_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;


    public function transform( Department $item )
    {
    
        return [
            'id'          => $item->id,
            'name'        => $item->name,
            'active'      => $item->active,
            'description' => $item->description,
            'parent'      => $item->parent
        ];

    }
}
