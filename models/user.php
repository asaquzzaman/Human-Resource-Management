<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HRM\Models\Leave_Type;
use HRM\Models\Meta;

class User extends Eloquent {

    protected $primaryKey = 'ID';
    protected $table      = 'users';

    protected $fillable = [
		'username',
    ];

    public function leave_types() {
        return $this->belongsToMany( Leave_Type::class, 'hrm_leave', 'emp_id', 'leave_type_id' );
    }
}
