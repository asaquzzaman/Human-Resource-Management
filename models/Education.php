<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Education extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_education';
    public $timestamps    = true;

    protected $fillable = [
		'level',
		'institute',
		'major',
		'gpa',
		'start',
		'end'
    ];
}

