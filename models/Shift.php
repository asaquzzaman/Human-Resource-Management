<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Department;
use HRM\Models\Relation;

class Shift extends Eloquent {

    protected $table      = 'hrm_time_shift';
    protected $primaryKey = 'id';
    public $timestamps    = true;

    protected $fillable = [
        'name',
        'status',
        'punch_start',
        'times',
        'created_at',
        'updated_at',
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
