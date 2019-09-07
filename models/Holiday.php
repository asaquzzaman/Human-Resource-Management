<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Holiday extends Eloquent {


    protected $primaryKey = 'id';
    protected $table      = 'hrm_holiday';
    public $timestamps    = false;

    protected $fillable = [
		'name',
		'description',
		'from',
		'to',
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
