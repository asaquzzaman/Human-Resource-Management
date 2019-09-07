<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Department;

class Designation extends Eloquent {

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    protected $primaryKey = 'id';
    protected $table      = 'hrm_designation';
    public $timestamps    = true;

    protected $fillable = [
		'title',
		'description',
		'department',
		'created_by',
        'updated_by',
    ];

    public function dept() {
        return $this->hasOne( 'HRM\Models\Department', 'id', 'department' );
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
