<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Notice extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_notice';
    public $timestamps    = false;

    protected $fillable = [
		'title',
        'description',
		'user_id',
		'date',
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
