<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Skill;
    
class Skill_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Skill $item )
    {
    
        return [
            'id'         => $item->id,
            'level'      => $item->level,
            'experiance' => $item->experiance,
            'comments'   => $item->comments
        ];

    }
}
