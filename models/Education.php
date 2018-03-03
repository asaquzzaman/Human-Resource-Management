<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Education extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_education';
    public $timestamps    = false;

    protected $fillable = [
    	'employee_id',
		'level',
		'institute',
		'major',
		'gpa',
		'start',
		'end',
		'created_by',
		'updated_by'
    ];
}

