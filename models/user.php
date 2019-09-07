<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave_Type;
use HRM\Models\Meta;

class User extends Eloquent {

    protected $primaryKey = 'ID';
    protected $table      = 'users';

    protected $fillable = [
		'username',
    ];

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function leave_types() {
        return $this->belongsToMany( 'HRM\Models\Leave_Type', hrm_tb_prefix() . 'hrm_leave', 'emp_id', 'type' );
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
