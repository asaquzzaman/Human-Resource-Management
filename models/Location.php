<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Location extends Eloquent {

    protected $table      = 'hrm_location';
    public $timestamps    = false;

    protected $fillable = [
        'name',
        'country',
        'state',
        'city',
        'address',
        'zipcode',
        'phone',
        'fax',
        'note'
    ];
}
