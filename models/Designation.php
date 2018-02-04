<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
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

    public function department() {
        return $this->hasOne( Department::class, 'id', 'department' );
    }
}
