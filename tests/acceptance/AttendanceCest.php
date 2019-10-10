<?php 

use \Codeception\Util\Locator;
use \Codeception\Util\ActionSequence;
use \Page\Acceptance\Attendance;

class AttendanceCest
{
    public function _before(AcceptanceTester $I, \Step\Acceptance\Login $login)
    {
        
        $login->asAdmin();
        
    }



    //tests
    public function AttendanceTest(AcceptanceTester $I)
    {
        
        (new Attendance($I) )->start();	
    	
    }

}
