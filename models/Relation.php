<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;
use HRM\Models\Leave;

class Relation extends Eloquent {


    protected $primaryKey = 'id';
    protected $table      = 'hrm_relation';
    public $timestamps    = false;

    protected $fillable = [
		'type',
		'from',
		'to',
    ];

}
