<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Location_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_location', function( $table ) {
            $table->increments( 'id' );
            $table->string( 'name' );
            $table->string( 'country' )->nullable();
            $table->string( 'state' )->nullable();
            $table->string( 'city' )->nullable();
            $table->string( 'address' )->nullable();
            $table->string( 'zipcode' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'fax' )->nullable();
            $table->string( 'note' )->nullable();
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();
            $table->timestamps();
        } );
    }
}