<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Attendance extends Eloquent {

    protected $table      = 'hrm_attendance';
    protected $primaryKey = 'id';
    public $timestamps    = true;

    protected $fillable = [
        'user_id',
        'date',
        'punch_in',
        'punch_out',
        'total',
        'shift_id',
        'updated_at',
        'created_at'
    ];

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
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
