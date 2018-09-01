<?php

function hrm_condition( $condition, $true_val, $false_val ) {
    return $condition ? $true_val : $false_val;
}

function hrm_division_rest($x, $y) {
	return $x%$y;
}

function hrm_actual_rate( $x ) {
	$last_day = date('t', current_time('mysql'));
	$employee_join_day = 10;

	return $x * ( $employee_join_day/$last_day );
}

function hrm_additon() {
    $args = func_get_args();

    return array_sum( $args );
}


function hrm_formula_replace( $salary, $formula, $formulas_name, $monthly_salary = true ) {

    $hrm_annual_salary = ! $monthly_salary ? $salary : $salary*12;
    $hrm_monthly_salary = $monthly_salary ? $salary : $salary/12;

    $names    = array_keys( $formulas_name );
    $formulas = array_values( $formulas_name );

    $string = strtolower( $formula );

    //remove all white space
    $string = preg_replace('/\s+/', '', $string);
    $search = array(
        'annual_salary',
        'monthly_salary',
        'if(',
        'greatest(',
        'least(',
        'mod(',
        'sum(',
        'prorate(',
        '%'
     );

    $search = array_merge( $search, $names );

    $replace = array(
        $hrm_annual_salary,
        $hrm_monthly_salary,
        'hrm_condition(',
        'max(',
        'min(',
        'hrm_division_rest(',
        'hrm_additon(',
        'hrm_actual_rate(',
        '/100'
    );

    $replace = array_merge( $replace, $formulas );
   

    $formula = str_replace( $search, $replace, $string );
    $row_fromula = hrm_nested_replace( $search, $replace, $string ); 
    
    return eval( 'return '. $row_fromula . ';' );
 }



function hrm_nested_replace( $search, $replace, $old_formula ) {

    $old_formula = strtolower( $old_formula );
    $old_formula = preg_replace('/\s+/', '', $old_formula);
    $new_formula = str_replace( $search, $replace, $old_formula );
    
    if ( $new_formula == $old_formula ) {
        return $new_formula;
    }

    return hrm_nested_replace( $search, $replace, $new_formula );
}

