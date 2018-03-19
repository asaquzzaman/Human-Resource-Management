<?php

namespace HRM\Core\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Migration_Model extends Eloquent {
    protected $table;

    public function __construct( array $attributes = [] ) {
    	
        $this->table = 'hrm_migrations';

        parent::__construct( $attributes );
    }

    protected $fillable = [
        'id',
        'migration'
    ];
}