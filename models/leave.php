<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Leave extends Eloquent {

    public $create_rules = array (
        'leave_status' => array (
            
            'type' => 'required|email|maxLenght(10)',
            
            'message' => array(
                'required'  =>  'This field is required',
                'email'     =>  'Please insert a valid mail',
                'maxLenght' =>  'Character lenght must be bellow 10 desit',            
            )
        ),

        'leave_comments' => array (
            
            'type' => 'required',
            
            'message' => array(
                'required'  =>  'This field is required',
          
            )
        )
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
