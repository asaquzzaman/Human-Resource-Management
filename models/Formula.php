<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;


class Formula extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_formula';
    public $timestamps    = true;

    protected $fillable = [
		'name',
		'description',
		'type',
        'formula',
        'status',
		'created_by',
        'updated_by',
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
