<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Work_Experience;
    
class Work_Experiance_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( Work_Experience $item )
    {
    
        return [
            'id'             => $item->id,
            'emp_number'     => $item->emp_number,
            'eexp_company'   => $item->eexp_company,
            'eexp_jobtit'    => $item->eexp_jobtit,
            'eexp_from_date' => hrm_get_date( $item->eexp_from_date ),
            'eexp_to_date'   => hrm_get_date( $item->eexp_to_date ),
            'eexp_comments'  => $item->eexp_comments
        ];

    }
}
