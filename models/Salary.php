<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Salary extends Eloquent {

    protected $table      = 'hrm_salary';
    public $timestamps    = true;

    protected $fillable = [
        'month',
        'category',
        'category_id',
        'employee_id',
        'group_id',
        'salary_components_id',
        'all_components_id',
        'info',
        'type',
        'salary',
        'created_by',
        'updated_by'
    ];
}
