<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Financial_Year_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_financial_year', function( $table ) {
            $table->increments( 'id' );
            $table->timestamp( 'start' )->nullable();
            $table->timestamps();
        } );
    }
}