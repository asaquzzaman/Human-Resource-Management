<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Organization_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_organization', function( $table ) {
            $table->increments( 'id' );
            $table->string( 'name' )->nullable();
            $table->string( 'taxid' )->nullable();
            $table->string( 'regnumber' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'fax' )->nullable();
            $table->string( 'address1' )->nullable();
            $table->string( 'address2' )->nullable();
            $table->string( 'city' )->nullable();
            $table->string( 'state' )->nullable();
            $table->string( 'zipcode' )->nullable();
            $table->string( 'country' )->nullable();
            $table->string( 'note' )->nullable();
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();
            $table->timestamps();
        } );
    }
}