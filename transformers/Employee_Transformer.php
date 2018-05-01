<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Designation;
use HRM\Models\Department;
use HRM\Models\Location;
use HRM\Core\File_System\File_System;
use HRM\Transformers\Department_Transformer;
use HRM\Transformers\Designation_Transformer;
use HRM\Transformers\Location_Transformer;

class Employee_Transformer extends TransformerAbstract
{
    use Resource_Editors, Transformer_Manager;

    public function transform( $item ) {
        
        return [
            'id'           => $item->ID,
            'email'        => $item->user_email,
            'display_name' => $item->display_name,
            'firstName'    => get_user_meta( $item->ID, 'first_name', true ),
            'lastName'     => get_user_meta( $item->ID, 'last_name', true ),
            'department'   => $this->get_department( $item ),
            'location'     => $this->get_location( $item ),
            'description'  => get_user_meta( $item->ID, 'hrm_job_desc', true ),
            'status'       => $this->get_status( $item ),
            'mobileNumber' => get_user_meta( $item->ID, 'hrm_mob_number', true ),
            'joiningDate'  => hrm_get_date( get_user_meta( $item->ID, 'hrm_joined_date', true ) ),
            'gender'       => $this->get_gender( $item ),
            'role'         => $this->get_role( $item ),
            'designation'  => $this->get_designation( $item ),
            'avatar'       => $this->get_avatar( $item ),
            'can_update'   => hrm_user_can( 'edit_employee', $item->ID ),
            'marital_status' => get_user_meta( $item->ID, 'hrm_marital_status', true ),
            'national_code'  => get_user_meta( $item->ID, 'hrm_national_code', true ),
            'birthday'       => hrm_get_date2mysql( get_user_meta( $item->ID, 'hrm_birthday', true ) ),
            'street1'        => get_user_meta( $item->ID, 'hrm_street1', true ),
            'street2'        => get_user_meta( $item->ID, 'hrm_street2', true ),
            'city_code'      => get_user_meta( $item->ID, 'hrm_city_code', true ),
            'state'          => get_user_meta( $item->ID, 'hrm_state', true ),
            'zip'            => get_user_meta( $item->ID, 'hrm_zip', true ),
            'work_mobile'    => get_user_meta( $item->ID, 'hrm_work_mobile', true ),
            'country_code'   => get_user_meta( $item->ID, 'hrm_country_code', true ),
            //'default_profile_pic' => get_avatar_url( $item->ID )
        ];
    }

    public function get_gender( $item ) {
        $gender = get_user_meta( $item->ID, 'hrm_gender', true );

        if ( empty( $gender ) ) {
            return null;
        }

        return [
            'key'   => $gender,
            'label' => hrm_employee_gender( $gender )
        ];
    }

    public function get_role( $item ) {
        $role =  get_user_meta( $item->ID, 'hrm_role', true );

        if ( empty( $role ) ) {
            return null;
        }

        return [
            'name' => $role,
            'display_name' => hrm_get_roles( $role )
        ];
    }

    public function get_avatar( $item ) {
        $image_id = get_user_meta( $item->ID, 'hrm_user_image_id', true );
        
        if ( empty( $image_id ) ) {
            return array(
                'url' => get_avatar_url( $item->user_email )
            );
        }

        $file = File_System::get_file( $image_id );
        
        return $file;
    }

    public function get_designation( $item ) {
        $designation_id  = get_user_meta( $item->ID, 'hrm_designation', true );
        $designation     = Designation::find( $designation_id );

        if ( $designation ) {
            $designation = $this->item( $designation, new Designation_Transformer );
            return $this->get_response( $designation );
        }

        return null;
    }

    public function get_status( $item ) {
        $status = get_user_meta( $item->ID, 'hrm_status', true );

        if ( empty( $status ) ) {
            return null;
        }

        return [
            'key'   => $status,
            'label' => hrm_employee_status( $status )
        ];
    }

    public function get_location( $item ) {
        $location_id = get_user_meta( $item->ID, 'hrm_location', true );
        $location    = Location::find( $location_id );

        if ( $location ) {
            $location = $this->item( $location, new Location_Transformer );
            return $this->get_response( $location  );
        }

        return null;
    }

    public function get_department( $item ) {
        $department_id = get_user_meta( $item->ID, 'hrm_job_category', true );
        $department    = Department::find( $department_id );

        if ( $department ) {
            $department = $this->item( $department, new Department_Transformer );
            return $this->get_response( $department );
        }

        return null;
    }
}
