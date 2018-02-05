<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Education_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_education', function( $table ) {
            $table->increments( 'id' );
            $table->string( 'level' );
            $table->string( 'institute' )->nullable();
            $table->string( 'major' )->nullable();
            $table->string( 'gpa' )->nullable();
            $table->timestamp( 'start' )->nullable();
            $table->timestamp( 'end' )->nullable();
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();
            $table->timestamps();
        } );
    }
}