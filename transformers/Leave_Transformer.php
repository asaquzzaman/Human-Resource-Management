<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use HRM\Models\Leave;
use HRM\Transformers\Leave_Type_Transform;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
    
class Leave_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    protected $defaultIncludes = [
        'employee'
    ];

    public function transform( Leave $item )
    {
    
        return [
            'id'         => (int) $item->id,
            'status'     => $item->status,
            'comments'   => $item->comments,
            'leave_type' => $this->includeLeaveType( $item ), //$item->leaveType,
            'emp_id'     => $item->emp_id,
            'start_time' => $item->start_time,
            'end_time'   => $item->end_time,
            'apply_at'   => $item->created_at,
            'avatar'     => hrm_get_avater( $item->emp_id )
        ];

    }

    public function includeLeaveType( Leave $item ) {
        if ( $item->type === '0' ) {
            return [
                'data' => [
                    'name' => 'Extra'
                ]
            ];
        }

        $leave_type = $item->leaveType
            ->where( 'id', $item->type )
            ->first();

        $resource   = new Item( $leave_type, new Leave_Type_Transform );
 
        return $this->get_response( $resource );
        
    }
}
