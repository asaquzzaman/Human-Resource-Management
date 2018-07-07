<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Attendance extends Eloquent {

    protected $table      = 'wp_hrm_attendance';
    protected $primaryKey = 'id';
    public $timestamps    = true;

    protected $fillable = [
        'user_id',
        'date',
        'punch_in',
        'punch_out',
        'total',
        'shift_id',
    ];
}
