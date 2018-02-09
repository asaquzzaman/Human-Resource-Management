<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use HRM\Models\Organization;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
    
class Organization_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

 
    public function transform( Organization $item )
    {
    
        return [
            'id'        => (int) $item->id,
            'name'      => $item->name,
            'taxid'     => $item->taxid,
            'regnumber' => $item->regnumber,
            'phone'     => $item->phone,
            'fax'       => $item->fax,
            'address1'  => $item->address1,
            'address2'  => $item->address2,
            'city'      => $item->city,
            'state'     => $item->state,
            'zipcode'   => $item->zipcode,
            'country'   => $item->country,
            'note'      => $item->note,
        ];

    }
}
