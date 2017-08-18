<?php
namespace HRM\Src\Leave\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Leave extends Eloquent {

    protected $rules = array(
        'leave_status' => array(
            
            'type' => 'required|email|maxLenght(10)',
            
            'message' => array(
                'required'  => __( 'This field is required', 'hrm' ),
                'email'     => __( 'Please insert a valid mail', 'hrm' ),
                'maxLenght' => __( 'Character lenght must be bellow 10 desit', 'hrm' )
            )
        ),

    );


    protected $primaryKey = 'id';
    protected $table = 'hrm_leave';
    public $timestamps = false;

    protected $fillable = [
		'leave_status',
		'leave_comments',
		'leave_type_id',
		'emp_id',
		'start_time',
		'end_time',
    ];
}
