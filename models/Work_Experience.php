<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Work_Experience extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_work_experience';
    public $timestamps    = true;

    protected $fillable = [
		'title',
		'start',
		'end',
		'description'
    ];
}

