<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Location extends Eloquent {

    protected $table      = 'hrm_location';
    public $timestamps    = false;

    protected $fillable = [
        'name',
        'country_code',
        'province',
        'city',
        'address',
        'zip_code',
        'phone',
        'fax',
        'notes'
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
