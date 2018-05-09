<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Holiday extends Eloquent {


    protected $primaryKey = 'id';
    protected $table      = 'hrm_holiday';
    public $timestamps    = false;

    protected $fillable = [
		'name',
		'description',
		'from',
		'to',
    ];
}
