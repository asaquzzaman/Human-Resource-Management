<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Notice_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_notice', function( $table ) {
            $table->increments( 'id' );
            $table->string( 'title' );
            $table->text( 'description' )->nullable();
            $table->timestamp('date');
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();
            $table->timestamps();
        } );
    }
}