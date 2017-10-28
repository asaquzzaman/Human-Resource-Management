<?php
namespace HRM\Src\Leave\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Leave extends Eloquent {

    protected $rules = array (
        'status' => array (
            
            'type' => 'required|email|maxLenght(10)',
            
            'message' => array(
                'required'  =>  'This field is required',
                'email'     =>  'Please insert a valid mail',
                'maxLenght' =>  'Character lenght must be bellow 10 desit',            
            )
        )
    );


    protected $primaryKey = 'id';
    protected $table = 'hrm_leave';
    public $timestamps = false;

    protected $fillable = [
		'status',
		'comments',
		'type',
		'emp_id',
		'start_time',
		'end_time',
    ];
}
