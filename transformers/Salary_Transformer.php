<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Salary;
    
class Salary_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;
        
    public function transform( Salary $item )
    {
        return [
            'id'                   => $item->id,
            'month'                => hrm_get_date( $item->month ),
            'category'             => $item->category,
            'category_id'          => $item->category_id,
            'employee'             => get_user_by( 'id', $item->employee_id ),
            'group_id'             => $item->group_id,
            'salary_components_id' => maybe_unserialize( $item->salary_components_id ),
            'all_components_id'    => maybe_unserialize( $item->all_components_id ),
            'info'                 => maybe_unserialize( $item->info ),
            'type'                 => $item->type,
            'salary'               => $item->salary,

        ];

    }
}
