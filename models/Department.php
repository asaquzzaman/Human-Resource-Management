<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Relation;

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
