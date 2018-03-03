<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Work_Experience extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_work_experience';
    public $timestamps    = false;

    protected $fillable = [
    	'employee_id',
		'title',
		'start',
		'end',
		'description',
		'created_at',
		'updated_at'
    ];
}

