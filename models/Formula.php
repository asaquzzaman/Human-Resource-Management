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
}
