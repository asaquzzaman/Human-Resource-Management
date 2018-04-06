<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;


class Formula extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_payroll_formula';
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
