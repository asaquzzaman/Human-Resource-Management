<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave;
use HRM\Models\Relation;
use HRM\Models\Department;

class Leave_Type extends Eloquent {


    protected $primaryKey = 'id';
    protected $table      = 'hrm_leave_type';
    public $timestamps    = false;

    protected $fillable = [
		'leave_type_name',
		'entitlement',
		'entitle_from',
		'entitle_to',
    ];

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function departments() {
    	return $this->belongsToMany( 'HRM\Models\Department', hrm_tb_prefix() . 'hrm_relation', 'from', 'to' );
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
