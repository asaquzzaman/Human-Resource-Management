<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Work_Experience extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_work_experience';
    public $timestamps    = false;

    protected $fillable = [
		'emp_number',
		'eexp_company',
		'eexp_jobtit',
		'eexp_from_date',
		'eexp_to_date',
		'eexp_comments'
    ];
}

