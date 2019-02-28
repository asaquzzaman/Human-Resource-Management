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
}

