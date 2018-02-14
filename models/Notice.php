<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Notice extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_notice';
    public $timestamps    = true;

    protected $fillable = [
		'title',
		'description',
		'date',
		'created_by',
        'updated_by',
    ];
}
