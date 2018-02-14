<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Skill_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'hrm_skill', function( $table ) {
            $table->increments( 'id' );
            $table->string( 'level' );
            $table->bigInteger( 'experiance' )->nullable();
            $table->text( 'comments' )->nullable();
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();
            $table->timestamps();
        } );
    }
}