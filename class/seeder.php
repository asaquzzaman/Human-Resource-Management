<?php

//HRM_Seeder::getInstance()->create_employees(50);
class HRM_Seeder {
	
	private static $instance;
    
    public static function getInstance() {
        if( ! self::$instance ) {
            self::$instance = new HRM_Seeder();
        }

        return self::$instance;
    }

	function create_employees( $length = 10 ) {

		for ( $i=0; $i < $length; $i++ ) { 
			
			$postdata['first_name']       = $this->generateRandomString();
			$postdata['last_name']        = $this->generateRandomString();
			$postdata['user_name']        = $this->generateRandomString();
			$postdata['email']            = $this->mail_generator();
			$postdata['emp_job_category'] = rand(1, 7);
			$postdata['emp_location']     = $this->generateRandomString();
			$postdata['job_desc']         = $this->generateRandomString();
			$postdata['status']           = array_rand(array('yes' => 'Enable', 'no'=> 'Desable'));
			$postdata['gender']           = array_rand(array('male' => '1', 'female'=> '2'));
			$postdata['mobile']           = rand(11, 11);

			Hrm_Employee::getInstance()->add_new_employee( $postdata );
		}
	}

	function generateRandomString() {
		$length = rand(5, 10);
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return ucfirst( $randomString );
	}

	function mail_generator() {
				// array of possible top-level domains
		$tlds = array("com", "net", "gov", "org", "edu", "biz", "info");

		// string of possible characters
		$char = "0123456789abcdefghijklmnopqrstuvwxyz";


		// main loop - this gives 1000 addresses
		

		// choose random lengths for the username ($ulen) and the domain ($dlen)
		$ulen = mt_rand(5, 10);
		$dlen = mt_rand(4, 4);

		// reset the address
		$a = "";

		// get $ulen random entries from the list of possible characters
		// these make up the username (to the left of the @)
		for ($i = 1; $i <= $ulen; $i++) {
		$a .= substr($char, mt_rand(0, strlen($char)), 1);
		}

		// wouldn't work so well without this
		$a .= "@";

		// now get $dlen entries from the list of possible characters
		// this is the domain name (to the right of the @, excluding the tld)
		for ($i = 1; $i <= $dlen; $i++) {
		$a .= substr($char, mt_rand(0, strlen($char)), 1);
		}

		// need a dot to separate the domain from the tld
		$a .= ".";

		// finally, pick a random top-level domain and stick it on the end
		$a .= $tlds[mt_rand(0, (sizeof($tlds)-1))];

		// done - echo the address inside a link
		  
		return $a;
	}
}