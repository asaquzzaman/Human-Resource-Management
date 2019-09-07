<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Salary extends Eloquent {

    protected $table      = 'hrm_salary';
    public $timestamps    = true;

    protected $fillable = [
        'month',
        'category',
        'category_id',
        'employee_id',
        'group_id',
        'salary_components_id',
        'all_components_id',
        'info',
        'type',
        'salary',
        'created_by',
        'updated_by'
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
