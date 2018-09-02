<?php
use HRM\Models\Designation;
use HRM\Models\Location;

//demo hrm_create_attendance('acclaim@wpspear.com','2018-08-01','2018-08-31');
function hrm_create_attendance( $email, $start, $last ) {
	global $wpdb;

	$user = get_user_by( 'email', $email );
	$id   = $user ? $user->id : false;

	if ( !$id ) {
		return;
	}

	$table = $wpdb->prefix . 'hrm_attendance';

	for ( $today=$start; $today<=$last; $today ) {
		
		$start = hrm_generate_random_date_time( $today );
		$end   = hrm_generate_random_date_time( $today );

		if ( $start >= $end ) continue;

		$data = array(
			'user_id'   => $id,
			'date'      => current_time( 'mysql' ),
			'punch_in'  => date( 'Y-m-d H:i:s', $start ),
			'punch_out' => date( 'Y-m-d H:i:s', $end ),
			'total'     => $end - $start,
			'shift_id'  => 2
        );

        $wpdb->insert( $table, $data );

        $today=date( 'Y-m-d H:i:s', strtotime( $today . "+1 day" ) );

	}
}

function hrm_generate_random_date_time( $today ) {
	$current_date = date('Y-m-d H:i:s', strtotime( $today ) );
	$current_plus_one = date('Y-m-d H:i:s', strtotime( $today . ' +1day' ) );

	$unix_start = strtotime( $current_date );
	$unix_end   = strtotime( $current_plus_one );
	$diff       = $unix_end - $unix_start;
	$rndtime    = $unix_start + mt_rand( 0, $diff );
	
	return $rndtime; //strtotime() fromat
}

function hrm_create_department() {
	$departements = hrm_unique_name_generator( 'Departement' );

	foreach ( $departements as $key => $depat_name ) {
		$departement = [
			'title' => $depat_name,
			'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
			'status' => 1
		];

		Hrm_Admin::update_department( $departement );
	}
}

function hrm_create_designation() {
	$designations = array( "Conquest","Terra",
        "Continuity","RedSky",
        "Concepts","Starboard",
        "Capstone","Wonder");

	$departements = Hrm_Admin::get_departments();

	foreach ( $designations as $key => $name) {
	
		$designation = [
			'title'        => $name,
			'department'   => hrm_get_random_dept_id( $departements ),
			'description'  => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
			'class'        => 'Designation',
			'method'       => 'create',
			'transformers' => 'Designation_Transformer'
		];

		hrm_insert_records( $designation );
	}
}

function hrm_get_random_dept_id( $departements ) {
	$departements = wp_list_pluck( $departements['departments'], 'id' );

	return $departements[array_rand($departements)];
}

function hrm_create_location() {
	$locations = hrm_unique_name_generator( 'Location' );

	foreach ( $locations as $key => $location_name ) {
		$location = array(
			'name'         => $location_name,
			'country_code' => 'BD',
			'class'        => 'Location',
			'method'       => 'create',
			'transformers' => 'Location_Transformer'
		);

		hrm_insert_records( $location );
	}
	

}

function hrm_create_employees() {
	$get_ids      = hrm_generate_email_user_name();
	$departements = Hrm_Admin::get_departments();
	$designations = Designation::get()->toArray();
	$locations    = Location::get()->toArray();
	$gender       = [1,2];
	
	foreach ( $get_ids as $key => $id ) {
		$user = array(
			'userName'     => $id['username'],
			'email'        => $id['email'],
			'firstName'    => hrm_fake_name_generate(),
			'lastName'     => hrm_fake_name_generate(),
			'department'   => hrm_get_random_dept_id( $departements ),
			'designation'  => hrm_get_random_event_id( $designations ),
			'location'     => hrm_get_random_event_id( $locations ),
			'role'         => hrm_employee_role_key(),
			'status'       => 1,
			'gender'       => $gender[array_rand($gender)],
			'mobileNumber' => '017176543765',
			'joiningDate'  => '2018-09-19',
			'description'  => 'Description about this employee'
		);

		Hrm_Employee::getInstance()->add_new_employee( $user );
	}


}

function hrm_get_random_event_id( $events ) {
	$events = wp_list_pluck( $events, 'id' );

	return $events[array_rand($events)];
}

function hrm_fake_name_generate() {
	$names = hrm_fake_name();

	return $names[array_rand($names)];
}

function hrm_generate_email_user_name() {
	$ids = [];
	$names = hrm_fake_name();

	foreach ( $names as $key => $name ) {
		$ids[] = [
			'email' => strtolower( $name ) . '@wpspear.com',
			'username' => strtolower( $name ),
		];
	}

	return $ids;
}

function hrm_unique_name_generator( $type ) {

	$firstNameCollection = hrm_fake_name();
	
	$fullNameCollection = array();

	while ( count( $fullNameCollection ) <= 100 ) {
	    $newFirstName = $firstNameCollection[rand(0, count($firstNameCollection)-1)];

	    if ( !in_array( $newFirstName, $fullNameCollection ) ) {
	        $fullNameCollection[] = $newFirstName;
	    }
	}

	foreach ( $fullNameCollection as $key => $name ) {
	    $fullNameCollection[$key] = $name .' '. $type;
	}

	return $fullNameCollection;
}


function hrm_fake_name() {
	return array("
		Carat","Avant",
        "Conquest","Terra",
        "Continuity","RedSky",
        "Concepts","Starboard",
        "Capstone","Wonder",
        "Empowerment","Symmetry",
        "Watershed","Countdown",
        "Anchor","Nut",
        "Exchange","Inn",
        "Paragon","RightNow",
        "Front","SilverLine",
        "MadDog","Lucent",
        "Awards","Petra",
        "Drift",
        "Division","Lifeline",
        "Stick","Proof",
        "Resolution","Lookout",
        "Tulip","Planetary",
        "Synergy","Gridiron",
        "Bluejay","Lens",
        "Delivery","Talisman",
        "Summer","Helium",
        "NewDay",
        "Sunshine", "Brooks",
        "Rachel","Edwards",
        "Christopher","Perez",
        "Thomas","Baker",
        "Sara","Moore",
        "Chris","Bailey",
        "Roger","Johnson",
        "Marilyn","Thompson",
        "Anthony","Evans",
        "Julie","Hall",
        "Paula","Phillips",
        "Annie","Hernandez",
        "Dorothy","Murphy",
        "Alice","Howard",
        "Ruth","Jackson",
        "Debra","Allen",
        "Gerald","Harris",
        "Raymond","Carter",
        "Jacqueline","Torres",
        "Joseph","Nelson",
        "Carlos","Sanchez",
        "Ralph","Clark",
        "Jean","Alexander",
        "Stephen","Roberts",
        "Eric","Long",
        "Amanda","Scott",
        "Teresa","Diaz",
        "Wanda","Hilltop",
		"Spots",
		"Acclaim",
		"BlackBelt",
		"Treehouse",
		"Renegade",
		"PureWater",
		"Montecarlo",
		"Themes",
		"Respect",
		"Mix",
		"AllAround",
		"Short",
		"Kindle",
		"Transition",
		"Giant",
		"Glass",
		"Peacock",
		"Creations",
		"Capricorn",
		"Rainmaker",
		"Consult",
		"Windmill",
		"Instrument"
	);
}





