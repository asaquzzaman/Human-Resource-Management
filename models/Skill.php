<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Skill extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_skill';
    public $timestamps    = true;

    protected $fillable = [
		'level',
		'experiance',
		'comments'
    ];
}

