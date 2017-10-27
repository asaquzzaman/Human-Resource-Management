<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HRM\Models\Leave_Type;

class Leave extends Eloquent {

    public $validation_rules =  array (
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

        'emp_id' => array (
            'type' => 'required',
            'message' => array(
                'required'  =>  'Please select employee',
            )
        ),

        'leave_type_id' => array (
            'type' => 'relational_required:disable_leave_type,false',
            'message' => array(
                'required'  =>  'Leave type is required',
            )
        )
    );

    protected $primaryKey = 'id';
    protected $table      = 'hrm_leave';
    public $timestamps    = true;

    protected $fillable = [
		'leave_status',
		'leave_comments',
		'leave_type_id',
		'emp_id',
		'start_time',
		'end_time',
    ];

    public function setEmpIdAttribute( $value ) {
        $this->attributes['emp_id'] = absint( $value ) > 0 ? $value : get_current_user_id();
    }

    public function setLeaveCommentsAttribute( $value ) {
        $this->attributes['leave_comments'] =  ! trim( $value )  ? __( 'No comment', 'hrm' ) : $value;
    }

    public function setLeaveStatusAttribute( $value ) {
        $this->attributes['leave_status'] =  absint( $value ) ? 1 : $value;
    }

    public function setLeaveTypeIdAttribute( $value ) {
        $this->attributes['leave_type_id'] =  absint( $value ) <= 0 ? 0 : $value;
    }

    public function leaveType() {
        return $this->hasOne( Leave_Type::class, 'id', 'leave_type_id' );
    }
}

