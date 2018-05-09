<?php
namespace HRM\Models;

use HRM\Core\Database\Model as Eloquent;

class Financial_Year extends Eloquent {

    protected $primaryKey = 'id';
    protected $table      = 'hrm_financial_year';
    public $timestamps    = true;

    protected $fillable = [
		'start',
    ];
}

