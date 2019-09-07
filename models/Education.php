<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Education extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_personal_education';
    public $timestamps    = false;

    protected $fillable = [
    	'employee_id',
		'education',
		'institute',
		'major',
		'year',
		'score',
		'start_date',
		'end_date'
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

