<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Attendance extends Eloquent {

    protected $table      = 'hrm_attendance';
    protected $primaryKey = 'id';
    public $timestamps    = true;

    protected $fillable = [
        'user_id',
        'date',
        'punch_in',
        'punch_out',
        'total',
        'shift_id',
        'updated_at',
        'created_at'
    ];
}
