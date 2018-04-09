<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Formula;
use HRM\Transformers\Formula_Transformer;
use HRM\Models\Salary_Group;
use HRM\Transformers\Salary_Group_Transformer;
use HRM\Models\Salary;
use HRM\Transformers\Salary_Transformer;

class Hrm_Payroll {
    use Transformer_Manager;

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function __construct() {
        add_action( 'wp_ajax_hrm_get_formula', array( $this, 'ajax_get_formula' ) );
        add_action( 'wp_ajax_hrm_group_filter', array( $this, 'ajax_group_filter' ) );
        add_action( 'wp_ajax_hrm_update_formula', array( $this, 'ajax_update_formula' ) );
        add_action( 'wp_ajax_hrm_delete_formula', array( $this, 'ajax_delete_formula' ) );
        add_action( 'wp_ajax_hrm_generate_salary_statement', array( $this, 'ajax_generate_salary_statement' ) );
        add_action( 'wp_ajax_hrm_get_employee_salary', array( $this, 'ajax_get_employee_salary' ) );

    }

    function ajax_get_employee_salary() {
        check_ajax_referer('hrm_nonce');
        $salary = self::getInstance()->get_employee_salary( $_POST );

        wp_send_json_success( $salary );
    }

    function get_employee_salary( $postData ) {
        $salary_id = $postData['salary_id'];

        if ( intval( $salary_id )  ) {

            $salary = Salary::find( $salary_id );
            
            if ( $salary ) {
                $resource = new item( $salary, new Salary_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        return $this->get_response( null );
    }

    function ajax_group_filter() {
        check_ajax_referer('hrm_nonce');
        $salary = self::getInstance()->group_filter( $_POST );

        wp_send_json_success( $salary );
    }

    function group_filter( $postData ) {
        $name = empty( $postData['name'] ) ? false : $postData['name'];
        $id   = empty( $postData['id'] ) ? false : intval( $postData['id'] );
        $per_page = hrm_per_page();
        $page   = empty(  $postData['page'] ) ? 1 : intval( $postData['page'] );
      

        if ( $id !== false  ) {

            $formual = Salary_Group::find( $id );
            
            if ( $formual ) {
                $resource = new Item( $formual, new Salary_Group_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        $formual = Salary_Group::where( function($q) use( $name ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page, ['*'], 'page', $page );
    
        $collection = $formual->getCollection();

        $resource = new Collection( $collection, new Salary_Group_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $formual ) );

        return $this->get_response( $resource );
    }

    function ajax_generate_salary_statement() {
        check_ajax_referer('hrm_nonce');
        $salary = self::getInstance()->generate_salary_statement( $_POST );

        wp_send_json_success( $salary );
    }

    function generate_salary_statement( $postData ) {
        $salary         = $postData['salary'];
        $group          = empty( $postData['group'] ) ? 0 : $postData['group'];
        $salary_period  = $postData['salary_period'] == 'monthly' ? true : false;
        $formulas       = $all_formulas = $this->get_formula();
        $formulas_name  = array();
        $generate_gross = 0;
        $deduction      = 0;
        $all_components_id = array();
        $salary_components_id = array();

        if ( $group ) {
            $get_group     = $this->group_filter(array('id' => $group));
            $components_id = array_merge( $get_group['data']['income'], $get_group['data']['deduction'] );
            $formulas = $this->get_formula( array( 'id' => $components_id ) );
        }

        foreach ( $all_formulas['data'] as $key => $formula ) {
            $formulas_name[$formula['name']] = $formula['formula'];
            $all_components_id[] = $formula['id'];
        }

        foreach ( $formulas['data'] as $key => $formula ) {
            $formulas['data'][$key]['amount'] = hrm_formula_replace( $salary, $formula['formula'], $formulas_name, $salary_period );
            
            if ( $formula['type'] == 'income' ) {
               $generate_gross = $generate_gross + $formulas['data'][$key]['amount']; 
            }

            if ( $formula['type'] == 'deduction' ) {
               $deduction = $deduction + $formulas['data'][$key]['amount']; 
            }

            $salary_components_id[] = $formula['id'];
        }

        $actual_salary = $salary;
        $salary = $salary_period ? $salary : $salary/12;

        if ( $generate_gross <  $salary ) {
            $formulas['meta']['salaryMeta']['others']         = $salary - $generate_gross;
            $formulas['meta']['salaryMeta']['incomeTotal']    = $salary;
            $formulas['meta']['salaryMeta']['deductionTotal'] = $deduction;
            $formulas['meta']['salaryMeta']['employeeGet']    = $salary - $deduction;
        }



        //if ( $postData['save'] == 'true' ) {

            $store_data = array(
                'month'                => $postData['month'],
                'category'             => $postData['category'],
                'category_id'          => $postData['category_id'],
                'employee_id'          => $postData['category'] == 'employee' ? $postData['category_id'] : 0,
                'group_id'             => $group,
                'salary_components_id' => maybe_serialize( $salary_components_id ),
                'all_components_id'    => maybe_serialize( $all_components_id ),
                'info'                 => maybe_serialize( $formulas ),
                'type'                 => $postData['salary_period'],
                'salary'               => $actual_salary,
                'created_by'           => get_current_user_id(),
                'updated_by'           => get_current_user_id()
            );
            //if ( $postData['id'] ) {
                $this->update_salary( $store_data );
            //} else {
               // $this->save_salary( $store_data );
            //}
            
       // }

        wp_send_json_success($formulas);
    }

    function update_salary( $store_data ) {
        $start_date = date( 'Y-m-01', strtotime( $store_data['month'] ) );
        $end_date = date( 'Y-m-t', strtotime( $store_data['month'] ) );

        if ( $store_data['category'] == 'employee' ) {
            $employee_id = $store_data['employee_id'];

            $salary = Salary::where('employee_id', $employee_id)
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
            
            
            if ( $salary ) {
                $salary = $salary->update( $store_data );
            } else {
                Salary::create( $store_data );
            }

            return;
        }

        $args = array(
            'meta_key'     => 'hrm_designation',
            'meta_value'   => $store_data['category_id'],
            'meta_compare' => '=',
            'number'       => -1
        );

        $users = get_users( $args );

        foreach ( $users as $user ) {
            $salary = Salary::where('employee_id', $user->ID)
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
            if ( $salary ) {
                $salary->update( $store_data );
            } else {
                $store_data['employee_id'] = $user->ID;
                Salary::create( $store_data );
            }
        }
    }

    function save_salary( $store_data ) {
        $start_date = date( 'Y-m-01', strtotime( current_time( 'mysql' ) ) );
        $end_date = date( 'Y-m-t', strtotime( current_time( 'mysql' ) ) );

        if ( $store_data['category'] == 'employee' ) {
            $employee_id = $store_data['employee_id'];

            $salary = Salary::where('employee_id', $employee_id)
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->get();
            $row_count = $salary->count();

            if ( !$row_count ) {
                Salary::create( $store_data );
                return;
            }
        }

        $args = array(
            'meta_key'     => 'hrm_designation',
            'meta_value'   => $store_data['category_id'],
            'meta_compare' => '=',
            'number'       => -1
        );

        $users = get_users( $args );

        $users_id = wp_list_pluck( $users, 'ID' );
        
        $salary = Salary::whereIn('employee_id', $users_id)
            ->where( function($q) use( $start_date, $end_date ) {
                $q->where( 'month', '>=', $start_date);
                $q->where( 'month', '<=', $end_date);
            })->get()->toArray();
        
        $exitance_emp = wp_list_pluck( $salary, 'employee_id' );

        foreach ( $users as $user ) {
            if ( in_array( $user->ID, $exitance_emp) ) {
                continue;
            }
            $store_data['employee_id'] = $user->ID;
            Salary::create( $store_data );
        }
    }

    function ajax_update_formula() {
        check_ajax_referer('hrm_nonce');
        $formula = self::getInstance()->update_formula( $_POST );

        wp_send_json_success( $formula );
    }

    function ajax_delete_formula() {
        check_ajax_referer('hrm_nonce');
        
        self::getInstance()->delete_formula( $_POST['delete'] );
        wp_send_json_success();
    }

    function delete_formula( $formula_ids ) {
        foreach ( $formula_ids as $key => $formula_id ) {
             $update = array(
                'class'        => 'Formula',
                'method'       => 'update',
                'transformers' => 'Formula_Transformer',
                'status'       => 'disable',
                'id'           => $formula_id
            );

            hrm_update_records( $update );
        }
    }

    function update_formula( $postdata ) {
        
        $update = array(
            'class'        => 'Formula',
            'method'       => 'update',
            'transformers' => 'Formula_Transformer',
            'status'       => 'disable',
            'id'           => empty( intval( $postdata[id] ) ) ? false : intval( $postdata[id] )
        );

        hrm_update_records( $update );

        $postdata['method'] =  'create';
        unset( $postdata['id'] );

        return hrm_insert_records( $postdata );
    }

    function ajax_get_formula() {
    	check_ajax_referer('hrm_nonce');

    	$formula = self::getInstance()->get_formula( $_POST );

    	wp_send_json_success( $formula );
    }

    function get_formula( $postData = array() ) {
		$name = empty( $postData['name'] ) ? false : $postData['name'];
		$id   = empty( $postData['id'] ) ? false : $postData['id'];
        $status = 'enable';
        $page = 1;
        $per_page = 100000;
      

       if ( $id !== false && !is_array( $id )  ) {

            $formual = Formula::find( $id );
            
            if ( $formual ) {
                $resource = new Item( $formual, new Formula_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        $formual = Formula::where( function($q) use( $name, $status, $id ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
            }
            if ( ! empty(  $status ) ) {
                $q->where( 'status', $status );
            }

            if ( is_array(  $id ) ) {
                $q->whereIn( 'id', $id );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page, ['*'], 'page', $page );
    
        $collection = $formual->getCollection();

        $resource = new Collection( $collection, new Formula_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $formual ) );

        return $this->get_response( $resource );
    }	
}