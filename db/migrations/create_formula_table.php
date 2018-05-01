<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Formula_Table extends Migration {
    public function schema() {
        $table = 'hrm_formula';
        
        if (!Capsule::schema()->hasTable( $table )) {
            Capsule::schema()->create( $table, function( $table ) {
                $table->increments( 'id' );
                $table->string( 'name' )->nullable();
                $table->text( 'description' )->nullable();
                $table->string( 'type' )->nullable();
                $table->text( 'formula' )->nullable();
                $table->string( 'status' )->nullable();
                $table->unsignedInteger( 'created_by' )->nullable();
                $table->unsignedInteger( 'updated_by' )->nullable();
                $table->timestamps();
            } );
        }
    }
}