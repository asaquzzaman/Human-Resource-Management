<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Department;

class Designation extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_designation';
    public $timestamps    = true;

    protected $fillable = [
		'title',
		'description',
		'department',
		'created_by',
        'updated_by',
    ];

    public function dept() {
        return $this->hasOne( 'HRM\Models\Department', 'id', 'department' );
    }
}
