<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use HRM\Core\Database\Abstract_Migration as Migration;

class Create_Salary_Table extends Migration {
    public function schema() {
        $table = 'hrm_salary';
        
        if (!Capsule::schema()->hasTable( $table )) {
            Capsule::schema()->create( $table, function( $table ) {
                $table->increments( 'id' );
                $table->timestamp( 'month' )->nullable();
                $table->string( 'category' )->nullable()->comment('employee, designation');
                $table->unsignedInteger( 'category_id' )->nullable();
                $table->bigInteger('employee_id');
                $table->unsignedInteger( 'group_id' )->nullable();
                $table->text( 'salary_components_id' )->nullable();
                $table->text( 'all_components_id' )->nullable();
                $table->text( 'info' )->nullable();
                $table->string( 'type' )->nullable()->comment('monthly, annual');
                $table->string( 'salary' )->nullable();
                $table->unsignedInteger( 'created_by' )->nullable();
                $table->unsignedInteger( 'updated_by' )->nullable();
                $table->timestamps();
            } );
        }
    }
}