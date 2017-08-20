<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Leave extends Eloquent {

    public $create_rules = array (
        'start_time' => array (
            'type' => 'required',
            'message' => array(
                'required'  =>  'Start time is required',
            )
        ),

        'end_time' => array (
            'type' => 'required',
            'message' => array(
                'required'  =>  'End time is required',
            )
        ),


    );


    protected $primaryKey = 'id';
    protected $table      = 'hrm_leave';
    public $timestamps    = false;

    protected $fillable = [
		'leave_status',
		'leave_comments',
		'leave_type_id',
		'emp_id',
		'start_time',
		'end_time',
    ];
}
