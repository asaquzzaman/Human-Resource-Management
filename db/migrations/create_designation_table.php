<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Designation_Table extends Migration {
    public function schema() {
        $table = 'hrm_designation';
        
        if (!Capsule::schema()->hasTable( $table )) {
            Capsule::schema()->create( $table, function( $table ) {
                $table->increments( 'id' );
                $table->string( 'title' )->nullable();
                $table->text( 'description' )->nullable();
                $table->bigInteger('department');
                $table->unsignedInteger( 'created_by' )->nullable();
                $table->unsignedInteger( 'updated_by' )->nullable();
                $table->timestamps();
            } );
        }
    }
}