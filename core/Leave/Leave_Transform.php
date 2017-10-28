<?php

namespace HRM\Core\Leave;

use League\Fractal\TransformerAbstract;
use HRM\Models\Leave;
use HRM\Core\Leave\Leave_Type_Transform;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
    
class Leave_Transformer extends TransformerAbstract
{
    use Resource_Editors;

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
        ];

    }

    public function includeLeaveType( Leave $item ) {
        if ( $item->type === '0' ) {
            return [
                'name' => 'Extra'
            ];
        }

        $leave_type = $item->leaveType;
        $leave_type_transform = new Leave_Type_Transform();
 
        return $leave_type_transform->transform($leave_type);
        
    }
}
