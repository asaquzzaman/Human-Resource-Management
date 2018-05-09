<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave_Type;

class Meta extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'people_meta';

    protected $fillable = [
		'meta',
    ];

    public function leave_types() {
        return $this->belongsToMany( 'HRM\Models\Leave_Type', hrm_tb_prefix() . 'hrm_leave', 'emp_id', 'type' );
    }
}
