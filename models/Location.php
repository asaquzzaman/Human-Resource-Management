<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Location extends Eloquent {

    protected $table      = 'hrm_location';
    public $timestamps    = false;

    protected $fillable = [
        'name',
        'country_code',
        'province',
        'city',
        'address',
        'zip_code',
        'phone',
        'fax',
        'notes'
    ];
}
