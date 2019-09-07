<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Work_Experience extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_work_experience';
    public $timestamps    = true;

    protected $fillable = [
    	'employee_id',
		'title',
		'start',
		'end',
		'description',
		'created_at',
		'updated_at'
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

