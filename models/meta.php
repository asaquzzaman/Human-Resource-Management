<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave_Type;

class Meta extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'people_meta';

    protected $fillable = [
		'meta',
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
