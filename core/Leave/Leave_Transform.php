<?php

namespace HRM\Core\Leave;

use HRM\Models\Leave;
use League\Fractal\TransformerAbstract;

class Leave_Transformer extends TransformerAbstract
{
    public function transform( Leave $item )
    {
        return [
            'id'             => (int) $item->id,
            'status'         => $item->status,
            'leave_comments' => $item->leave_comments,
            'leave_type_id'  => $item->leave_type_id,
            'emp_id'         => $item->emp_id,
            'start_time'     => $item->start_time,
            'end_time'       => $item->end_time,
        ];
    }
}