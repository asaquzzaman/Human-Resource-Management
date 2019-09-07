<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave_Type;
use HRM\Models\User;

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

        'type' => array (
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
		'status',
		'comments',
		'type',
		'emp_id',
		'start_time',
		'end_time',
    ];

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function setEmpIdAttribute( $value ) {
        $this->attributes['emp_id'] = absint( $value ) > 0 ? $value : get_current_user_id();
    }

    public function setLeaveCommentsAttribute( $value ) {
        $this->attributes['comments'] =  ! trim( $value )  ? __( 'No comment', 'hrm' ) : $value;
    }

    public function setLeaveStatusAttribute( $value ) {
        $this->attributes['status'] =  absint( $value ) ? 1 : $value;
    }

    public function setLeaveTypeIdAttribute( $value ) {
        $this->attributes['type'] =  absint( $value ) <= 0 ? 0 : $value;
    }

    public function leaveType() {
        return $this->hasOne( 'HRM\Models\Leave_Type', 'id', 'type' );
    }

    public function user() {
        return $this->hasOne( 'HRM\Models\User', 'ID', 'emp_id' );
    }

    public static function sanitize() {
        $instance = self::getInstance();
        $postdata = [];

        foreach ( $instance->fillable as $key => $fillable ) {
            
            if ( isset( $_POST[$fillable] ) ) {
                $postdata[$fillable] = hrm_clean( $_POST[$fillable] );
            }
        }

        return $postdata;
    }
}

