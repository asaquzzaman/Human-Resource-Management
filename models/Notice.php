<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Notice extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_notice';
    public $timestamps    = false;

    protected $fillable = [
		'title',
        'description',
		'user_id',
		'date',
    ];
}
