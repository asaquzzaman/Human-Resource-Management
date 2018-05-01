<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Formula;
    
class Formula_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Formula $item )
    {
        return [
            'id'          => $item->id,
            'name'        => $item->name,
            'description' => $item->description,
            'type'        => $item->type,
            'formula'     => $item->formula,
            'status'      => $item->status,
        ];

    }
}
