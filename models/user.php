<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave_Type;
use HRM\Models\Meta;

class User extends Eloquent {

    protected $primaryKey = 'ID';
    protected $table      = 'users';

    protected $fillable = [
		'username',
    ];

    public function leave_types() {
        return $this->belongsToMany( 'HRM\Models\Leave_Type', hrm_tb_prefix() . 'hrm_leave', 'emp_id', 'type' );
    }
}
