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
use HRM\Core\Crud\Crud;
use Illuminate\Pagination\Paginator;

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
        add_action( 'wp_ajax_hrm_fetch_statement', array( $this, 'ajax_fetch_statement' ) );
        add_action( 'wp_ajax_hrm_get_salary', array( $this, 'ajax_get_salary' ) );
        add_action( 'wp_ajax_hrm_insert_formula', array( $this, 'ajax_insert_formula' ) );
        add_action( 'wp_ajax_hrm_check_formula_validity', array( $this, 'ajax_check_formula_validity' ) );
        add_action( 'wp_ajax_hrm_delete_salary', array( $this, 'ajax_delete_salary' ) );

    }

    function ajax_delete_salary() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'delete' => isset( $_POST['delete'] ) ? hrm_clean( $_POST['delete'] ) : '',
            'class'  => isset( $_POST['class'] ) ? hrm_clean( $_POST['class'] ) : '',
            'method' => isset( $_POST['method'] ) ? hrm_clean( $_POST['method'] ) : '',
        ];

        $records = self::getInstance()->delete_salary( $postdata );
        wp_send_json_success($records);
    }

    function delete_salary( $postdata ) {
        $delete = Crud::data_process( $postdata );
        do_action( 'hrm_after_delete_salary', $postdata );

        return $delete;
    }

    function ajax_insert_formula() {
        check_ajax_referer('hrm_nonce');
      
        $postdata = [
            'class'        => isset( $_POST['class'] ) ? hrm_clean( $_POST['class'] ) : '',
            'method'       => isset( $_POST['method'] ) ? hrm_clean( $_POST['method'] ) : '',
            'transformers' => isset( $_POST['transformers'] ) ? hrm_clean( $_POST['transformers'] ) : '',
            'name'         => isset( $_POST['name'] ) ? hrm_clean( $_POST['name'] ) : '',
            'formula'      => isset( $_POST['formula'] ) ? hrm_clean( $_POST['formula'] ) : '',
            'status'       => isset( $_POST['status'] ) ? hrm_clean( $_POST['status'] ) : '',
            'type'         => isset( $_POST['type'] ) ? hrm_clean( $_POST['type'] ) : '',
            'description'  => isset( $_POST['description'] ) ? hrm_clean( $_POST['description'] ) : '',
        ];

        $salary = self::getInstance()->insert_formula( $postdata );

        wp_send_json_success( $salary );
    }

    function insert_formula( $postData ) {
        
        $formula_val = $this->formula_validator( $postData['formula'] );

        if ( !floatval( $formula_val ) ) {
            wp_send_json_error(array(
                'error' => array(
                    'Formula is not valid!'
                )
            ));
        }
        
        return hrm_insert_records($postData);
    }

    function update_formula( $postdata ) {

        $formula_val = $this->formula_validator( $postdata['formula'] );
        
        if ( !floatval( $formula_val ) ) {
            wp_send_json_error(array(
                'error' => array(
                    'Formula is not valid!'
                )
            ));
        }

        $postdata['id'] = intval( $postdata['id'] );
        
        $update = array(
            'class'        => 'Formula',
            'method'       => 'update',
            'transformers' => 'Formula_Transformer',
            'status'       => 'disable',
            'id'           => empty( $postdata['id'] ) ? false : intval( $postdata['id'] )
        );

        hrm_update_records( $update );

        $postdata['method'] =  'create';
        unset( $postdata['id'] );

        return hrm_insert_records( $postdata );
    }

    function formula_validator( $defination ) {
        $salary         = '1000000';
        $salary_period  = true;
        $all_formulas = $this->get_formula();
        $formulas_name  = array();
    

        foreach ( $all_formulas['data'] as $key => $formula ) {
            $formulas_name[$formula['name']] = $formula['formula'];
        }
        
        return hrm_formula_replace( $salary, $defination, $formulas_name, $salary_period );
      
    }

    function ajax_check_formula_validity() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'formula' => isset( $_POST['formula'] ) ? hrm_clean( $_POST['formula'] ) : '',
        ];
        
        $formula_val = self::getInstance()->formula_validator( $postdata['formula'] );

        if ( floatval( $formula_val ) ) {
            wp_send_json_success(
                array(
                    'message' =>'Formula is valid!'
                )
            );
        }

        wp_send_json_error(array(
            'error' => array(
                'Formula is not valid!'
            )
        ));
    }

    function ajax_get_salary() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'from'        => isset( $_POST['from'] ) ? hrm_clean( $_POST['from'] ) : '',
            'page'        => isset( $_POST['page'] ) ? hrm_clean( $_POST['page'] ) : '',
            'id'          => isset( $_POST['id'] ) ? hrm_clean( $_POST['id'] ) : '',
            'employee_id' => isset( $_POST['employee_id'] ) ? hrm_clean( $_POST['employee_id'] ) : '',
        ];

        $salary = self::getInstance()->get_salary( $postdata );

        wp_send_json_success( $salary );
    }

    function get_salary( $postData ) {
        $salary_date  = empty( $postData['from'] ) ? current_time( 'mysql' ) : hrm_clean( $postData['from'] );
        $start_date  = date( 'Y-m-01', strtotime( $salary_date ) );
        $end_date    = date( 'Y-m-t', strtotime( $salary_date ) );
        $page        = empty( $postData['page'] ) ? 1 : intval( $postData['page'] );
        $id          = empty( $postData['id'] ) ? false : intval( $postData['id'] );

        $per_page = hrm_per_page();

        if ( hrm_user_can( 'manage_payroll' ) ) {
            $employee_id = empty( $postData['employee_id'] ) ? '' : intval( $postData['employee_id'] );
        } else {
            $employee_id = get_current_user_id();
        }
 
        if ( $id !== false  ) {

            $location = Salary::find( $id );
            
            if ( $location ) {
                $resource = new Item( $location, new Salary_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $location = Salary::where( function($q) use( $start_date, $end_date, $employee_id ) {

            if ( ! empty(  $employee_id ) ) {
                $q->where( 'employee_id', $employee_id );
            }

            if ( ! empty( $start_date ) ) {
                $start_date = date( 'Y-m-d', strtotime( $start_date ) );
                $q->where( 'month', '>=', $start_date);
            }

            if ( ! empty( $end_date ) ) {
                $end_date = date( 'Y-m-d', strtotime( $end_date ) );
                $q->where( 'month', '<=', $end_date);
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );

        $collection = $location->getCollection();

        $resource = new Collection( $collection, new Salary_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $location ) );

        return $this->get_response( $resource );
    }

    function ajax_fetch_statement() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'id'        => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'type'      => isset( $_POST['type'] ) ? hrm_clean( $_POST['type'] ) : '',
            'salaryDay' => isset( $_POST['salaryDay'] ) ? hrm_clean( $_POST['salaryDay'] ) : '',
        ];
        //hr_pr($postdata); die();
        $salary = self::getInstance()->fetch_statement( $postdata );

        wp_send_json_success( $salary );
    }

    function fetch_statement( $postData ) {
        $id   = intval( $postData['id'] );
        $type = hrm_clean( $postData['type'] );
        $date = hrm_clean( $postData['salaryDay'] );

        $start_date = date( 'Y-m-01', strtotime( $date ) );
        $end_date = date( 'Y-m-t', strtotime( $date ) );

        if ( $type == 'employee' ) {
             $salary = Salary::where('employee_id', $id)
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
        } else {
             $salary = Salary::where('category_id', $id)
                ->where( 'category', $type )
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
        }
        
        if ( $salary ) {
            $resource = new item( $salary, new Salary_Transformer );
            return $this->get_response( $resource );
        }
    }

    function ajax_get_employee_salary() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'salary_id' => isset( $_POST['salary_id'] ) ? hrm_clean( $_POST['salary_id'] ) : '',
        ];

        $salary = self::getInstance()->get_employee_salary( $postdata );

        wp_send_json_success( $salary );
    }

    function get_employee_salary( $postData ) {
        $salary_id = intval( $postData['salary_id'] );

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
        
        $postdata = [
            'id' => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'name' => isset( $_POST['name'] ) ? hrm_clean( $_POST['name'] ) : '',
            'page' => isset( $_POST['page'] ) ? intval( $_POST['page'] ) : '',

        ];

        $salary = self::getInstance()->group_filter( $postdata );

        wp_send_json_success( $salary );
    }

    function group_filter( $postData ) {
        $name = empty( $postData['name'] ) ? false : hrm_clean( $postData['name'] );
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

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $formual = Salary_Group::where( function($q) use( $name ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $formual->getCollection();

        $resource = new Collection( $collection, new Salary_Group_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $formual ) );

        return $this->get_response( $resource );
    }

    function ajax_generate_salary_statement() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'id'            => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'salary'        => isset( $_POST['salary'] ) ? hrm_clean( $_POST['salary'] ) : '',
            'group'         => isset( $_POST['group'] ) ? hrm_clean( $_POST['group'] ) : '',
            'salary_period' => isset( $_POST['salary_period'] ) ? hrm_clean( $_POST['salary_period'] ) : '',
            'save'          => isset( $_POST['save'] ) ? hrm_clean( $_POST['save'] ) : '',
            'isUpdate'      => isset( $_POST['isUpdate'] ) ? hrm_clean( $_POST['isUpdate'] ) : '',
            'category'      => isset( $_POST['category'] ) ? hrm_clean( $_POST['category'] ) : '',
            'category_id'   => isset( $_POST['category_id'] ) ? hrm_clean( $_POST['category_id'] ) : '',
            'month'         => isset( $_POST['month'] ) ? hrm_clean( $_POST['month'] ) : '',
            'salary_id'     => isset( $_POST['salary_id'] ) ? hrm_clean( $_POST['salary_id'] ) : '',
        ];

        $salary = self::getInstance()->generate_salary_statement( $postdata );

        wp_send_json_success( $salary );
    }

    function generate_salary_statement( $postData ) {
        $salary               = hrm_clean( $postData['salary'] );
        $group                = empty( $postData['group'] ) ? 0 : hrm_clean( $postData['group'] );
        $salary_period        = $postData['salary_period'] == 'monthly' ? true : false;
        $formulas             = $all_formulas = $this->get_formula();
        $formulas_name        = array();
        $generate_gross       = 0;
        $deduction            = 0;
        $all_components_id    = array();
        $salary_components_id = array();
        $is_save              = $postData['save'] == 'true' ? true : false;
        $is_update            = $postData['isUpdate'] == 'true' ? true : false;

        if ( $group ) {
            $get_group     = $this->group_filter(array('id' => $group));
            $components_id = array_merge( $get_group['data']['income'], $get_group['data']['deduction'] );
            $formulas = $this->get_formula( array( 'id' => $components_id ) );
        } 

        foreach ( $all_formulas['data'] as $key => $formula ) {
            $formulas_name[$formula['name']] = $formula['formula'];
            $all_components_id[] = $formula['id'];
        }

        $formulas = apply_filters( 'hrm_before_salary_generator', $formulas, $postData );
        
        foreach ( $formulas['data'] as $key => $formula ) {

            if ( ! empty( $formula['formula'] ) ) {
                $formulas['data'][$key]['amount'] = hrm_formula_replace( $salary, $formula['formula'], $formulas_name, $salary_period );
            }
            
            if ( $formula['type'] == 'income' ) {
               $generate_gross = $generate_gross + $formulas['data'][$key]['amount']; 
            }

            if ( $formula['type'] == 'deduction' ) {
               $deduction = $deduction + $formulas['data'][$key]['amount']; 
            }

            if ( isset( $formula['id'] ) ) {
                $salary_components_id[] = $formula['id'];    
            }
        }

        $actual_salary = $salary;
        $salary = $salary_period ? $salary : $salary/12;

        //if ( $generate_gross <  $salary ) {
            $formulas['meta']['salaryMeta']['others']         = ( $generate_gross <  $salary ) ? $salary - $generate_gross : 0;
            $formulas['meta']['salaryMeta']['incomeTotal']    = $salary;
            $formulas['meta']['salaryMeta']['deductionTotal'] = $deduction;
            $formulas['meta']['salaryMeta']['employeeGet']    = $salary - $deduction;
        //}

        $formulas = apply_filters( 'hrm_salary_generator', $formulas, $postData );

        if ( $is_save ) {

            $store_data = array(
                'month'                => date( 'Y-m-d', strtotime( hrm_clean( $postData['month'] ) ) ),
                'category'             => $postData['category'],
                'category_id'          => $postData['category_id'],
                'employee_id'          => $postData['category'] == 'employee' ? $postData['category_id'] : 0,
                'group_id'             => $group,
                'salary_components_id' => maybe_serialize( $salary_components_id ),
                'all_components_id'    => maybe_serialize( $all_components_id ),
                'info'                 => maybe_serialize( $formulas ),
                'type'                 => $postData['salary_period'],
                'salary'               => $actual_salary,
                'is_update'            => $postData['isUpdate'] == 'true' ? true : false,
                'created_by'           => get_current_user_id(),
                'updated_by'           => get_current_user_id()
            );
            
            $salary = $this->update_salary( $store_data );

            if ( is_wp_error( $salary ) ) {
                wp_send_json_error( array( 'error' => $salary->get_error_messages() ) );
            }
        }

        wp_send_json_success($formulas);
    }

    function update_salary( $store_data ) {
        $info = maybe_unserialize( $store_data['info'] );

        if( $info['meta']['salaryMeta']['employeeGet'] < 0 ) {
            return new WP_Error('employee_net_salary', 'Invalid net pay');
        }; 
        $is_update = $store_data['is_update'];
        $start_date = date( 'Y-m-01', strtotime( $store_data['month'] ) );
        $end_date = date( 'Y-m-t', strtotime( $store_data['month'] ) );

        if ( $store_data['category'] == 'employee' ) {
            $employee_id = $store_data['employee_id'];

            $salary = Salary::where('employee_id', $employee_id)
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
            
            
            if ( $salary && $is_update ) {
                $store_data = apply_filters( 'hrm_before_update_salary', $store_data, $salary );
                
                //if( $salary->category != 'designation' ) {
                    $salary = $salary->update( $store_data );
                //}
            
            } else {
                if ( !$salary ) {
                    $record = Salary::create( $store_data );
                    do_action( 'hrm_after_create_salary', $store_data, $record );
                }
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
            $salary_data = $store_data;
            $salary = Salary::where( 'employee_id', $user->ID )
                ->where( function($q) use( $start_date, $end_date ) {
                    $q->where( 'month', '>=', $start_date);
                    $q->where( 'month', '<=', $end_date);
                })->first();
            
            if ( $salary && $is_update ) {
                $salary_data['employee_id'] = $user->ID;
                $salary_data = apply_filters( 'hrm_before_update_salary', $salary_data, $salary );
                
                if( $salary->category != 'employee' ) {
                    $salary->update( $salary_data );
                }
                
            } else {
                if ( !$salary ) {
                    $salary_data['employee_id'] = $user->ID;
                    $salary_data = apply_filters( 'hrm_group_salary_generator', $salary_data );
                    $record = Salary::create( $salary_data );
                    do_action( 'hrm_after_create_salary', $salary_data, $record );
                }
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
        $postdata = [
            'id'      => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'formula' => isset( $_POST['formula'] ) ? hrm_clean( $_POST['formula'] ) : '',
        ];

        $formula = self::getInstance()->update_formula( $postdata );

        wp_send_json_success( $formula );
    }

    function ajax_delete_formula() {
        check_ajax_referer('hrm_nonce');
        
        self::getInstance()->delete_formula( hrm_clean( $_POST['delete'] ) );
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

    function ajax_get_formula() {
    	check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'id'      => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'name' => isset( $_POST['name'] ) ? hrm_clean( $_POST['name'] ) : '',
        ];

    	$formula = self::getInstance()->get_formula( $postdata );

    	wp_send_json_success( $formula );
    }

    function get_formula( $postData = array() ) {
        $name     = empty( $postData['name'] ) ? false : hrm_clean( $postData['name'] );
        $id       = empty( $postData['id'] ) ? false : hrm_clean( $postData['id'] );
        $status   = 'enable';
        $page     = 1;
        $per_page = 100000;
      
        if ( $id !== false && !is_array( $id )  ) {

            $formual = Formula::find( $id );
            
            if ( $formual ) {
                $resource = new Item( $formual, new Formula_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

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
        ->paginate( $per_page );
        
        $collection = $formual->getCollection();

        $resource = new Collection( $collection, new Formula_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $formual ) );

        return $this->get_response( $resource );
    }	
}