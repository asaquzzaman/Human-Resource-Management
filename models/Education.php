<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

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
		'end_date',
		'created_by',
		'updated_by'
    ];
}

