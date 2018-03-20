<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use HRM\Models\Location;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
    
class Location_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

 
    public function transform( Location $item )
    {
    
        return [
            'id'           => (int) $item->id,
            'name'         => $item->name,
            'country_code' => $item->country_code,
            'province'     => $item->province,
            'city'         => $item->city,
            'address'      => $item->address,
            'zip_code'     => $item->zip_code,
            'phone'        => $item->phone,
            'fax'          => $item->fax,
            'notes'        => $item->notes,
        ];

    }
}
