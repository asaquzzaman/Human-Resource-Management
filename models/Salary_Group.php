<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;


class Salary_Group extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_salary_group';
    public $timestamps    = true;

    protected $fillable = [
		'name',
		'income',
		'deduction',
		'created_by',
        'updated_by',
    ];

    public static function sanitize( $postData ) {
        $postData['income'] = maybe_serialize( $postData['income'] );
        $postData['deduction'] = maybe_serialize( $postData['deduction'] );

        return $postData;
    }
}
