<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Salary_Group_Table extends Migration {
    public function schema() {
        $table = 'hrm_salary_group';
        
        if (!Capsule::schema()->hasTable( $table )) {
            Capsule::schema()->create( $table, function( $table ) {
                $table->increments( 'id' );
                $table->string( 'name' )->nullable();
                $table->text( 'income' )->nullable();
                $table->text( 'deduction' )->nullable();
                $table->unsignedInteger( 'created_by' )->nullable();
                $table->unsignedInteger( 'updated_by' )->nullable();
                $table->timestamps();
            } );
        }
    }
}