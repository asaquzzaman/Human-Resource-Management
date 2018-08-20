<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Attendance;


class Attendance_Transformer extends TransformerAbstract {

    use Resource_Editors;

    public function transform( Attendance $item ) {
        return [
            'id'        => $item->id,
            'user_id'   => $item->user_id,
            'date'      => hrm_get_date( $item->date ),
            'punch_in'  => $item->punch_in,
            'punch_out' => $item->punch_out,
            'shift_id'  => $item->shift_id,
            'total_second' => $item->total,
            'second_to_time' => hrm_second_to_time_short_form( hrm_get_second( $item->punch_in, $item->punch_out ) )
        ];
    }

}