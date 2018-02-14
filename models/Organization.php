<?php
namespace HRM\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Organization extends Eloquent {

    protected $table      = 'hrm_organization';
    public $timestamps    = true;

    protected $fillable = [
        'name',
        'taxid',
        'regnumber',
        'phone',
        'fax',
        'address1',
        'address2',
        'city',
        'state',
        'zipcode',
        'country',
        'note'
    ];
}
