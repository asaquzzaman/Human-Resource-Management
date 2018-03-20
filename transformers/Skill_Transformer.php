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
            'id'          => $item->id,
            'employee_id' => $item->employee_id,
            'skill'       => $item->skill,
            'years_of_exp'  => $item->years_of_exp,
            'comments'    => $item->comments
        ];

    }
}
