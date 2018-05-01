<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Salary_Group;
    
class Salary_Group_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Salary_Group $item )
    {
        return [
            'id'        => $item->id,
            'name'      => $item->name,
            'income'    => maybe_unserialize( $item->income ),
            'deduction' => maybe_unserialize( $item->deduction ),
        ];

    }
}
