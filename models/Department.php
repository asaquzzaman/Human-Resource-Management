<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Department extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_job_category';
    public $timestamps    = false;

    protected $fillable = [
		'name',
		'active',
		'description',
		'parent',
    ];
}
