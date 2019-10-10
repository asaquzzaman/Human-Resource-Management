<?php
namespace Page\Acceptance;
use \Codeception\Util\Locator;
use \Codeception\Util\ActionSequence;


class Attendance 
{
    /**
     * @var \AcceptanceTester;
     */
    // protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function start() {
        $I = $this->acceptanceTester;

        //$this->shift();
        //$this->employee_attendance();
        //$this->admin_attendance();
        //$this->admin_attendance_reports();
        $this->configuration();
        

    }

    public function multiselect( $number ) {
        $I = $this->acceptanceTester;

        $I->click('.multiselect__select');
        $I->waitForElement( '.multiselect__element', 30 );
        $element = Locator::find( 'li', ['class' => 'multiselect__element'] );
        $I->click(Locator::elementAt( $element, $number ));
    }

    public function shift() {
    	$I = $this->acceptanceTester;

    	$I->amOnPage( '/wp-admin/admin.php?page=hr_management#/attendance/shift' );

    	$I->waitForElement('.wp-list-table', 20);
    	
    	if( $I->hasElement( 'input', ['id' => 'cb-select-all-1'] ) ) {
    		
    		$I->click( '#cb-select-all-1' );
	    	$I->selectOption( Locator::find( 'select', ['name' => 'action'] ), 'Delete' );
	    	$I->click( 'Apply' );
	    	$I->waitForElement('.no-result-found', 20);
    	}

    	$I->click( '.page-title-action' );
	    $I->wait( 1 );
	    $I->click('.hrm-shift-add-more');
	    $I->wait( 1 );
	    $I->fillField('.shift-name', $I->faker()->firstNameMale);
	    $I->fillField('.start-work-day', '08:00');
	    $I->fillField('.shift-begin', '09:00');
	    $I->fillField('.shift-end', '17:00');
	    $I->fillField('.work-shift-time-hour', '7');
	    $I->fillField('.work-shift-time-minute', '00');
	    $this->multiselect( 1 );
	    $I->click('.hrm-break-applicable-field');
	    $I->scrollTo( ['css' => '.hrm-time-form-field-wrap'], 0, 0 );
	    $I->wait( 1 );
	    $I->fillField('.break-begin', '13:00');
	    $I->fillField('.break-end', '13:30');
	    $I->click('.hrm-more-break-btn');
	    $I->wait( 1 );
	    $I->fillField(['css' => '.hrm-break-wrap:nth-child(2) .break-begin'], '15:00');
	    $I->fillField(['css' => '.hrm-break-wrap:nth-child(2) .break-end'], '15:30');


	    $I->scrollTo( ['css' => '.hrm-add-more-content:nth-child(3) .hrm-break-applicable-field'], 0, 0 );
	    $I->wait( 1 );
	    
	    $I->fillField( ['css' => '.hrm-add-more-content:nth-child(3) .shift-begin'], '18:00');
	    $I->fillField( ['css' => '.hrm-add-more-content:nth-child(3) .shift-end'], '23:00');
	    $I->fillField( ['css' => '.hrm-add-more-content:nth-child(3) .work-shift-time-hour'], '5');
	    $I->fillField( ['css' => '.hrm-add-more-content:nth-child(3) .work-shift-time-minute'], '00');


	    $I->click(['css' => '.hrm-add-more-content:nth-child(3) .multiselect__select']);
        $I->waitForElement( '.multiselect__element', 10 );
        //$element = Locator::find( 'li', ['class' => 'multiselect__element'] );
        $I->wait( 1 );
        $I->click(['css' => '.hrm-add-more-content:nth-child(3) li.multiselect__element:nth-child(2)']);
        $I->wait( 1 );
	    $I->click( ['css' => '.hrm-add-more-content:nth-child(3) .hrm-break-applicable-field'] );

	    $I->scrollTo( ['css' => '.hrm-add-more-content:nth-child(3) .hrm-time-form-field-wrap'], 0, 0 );
	    $I->wait( 1 );
	    $I->fillField(['css' => '.hrm-add-more-content:nth-child(3) .break-begin'], '20:00');
	    $I->fillField(['css' => '.hrm-add-more-content:nth-child(3) .break-end'], '20:30');
	    $I->click(['css' => '.hrm-add-more-content:nth-child(3) .hrm-more-break-btn'] );
	    $I->wait( 1 );
	    $I->fillField(['css' => '.hrm-add-more-content:nth-child(3) .hrm-break-wrap:nth-child(2) .break-begin'], '21:0');
	    $I->fillField(['css' => '.hrm-add-more-content:nth-child(3) .hrm-break-wrap:nth-child(2) .break-end'], '21:30');
	    

	    $I->click('Submit');



	    $I->wait( 2 );
    	
    }

    public function employee_attendance() {
    	$I = $this->acceptanceTester;

    	$I->amOnPage('/wp-login.php');
        $I->wait(1);
        $I->fillField('log', 'employee');
        $I->fillField('pwd', 'admin');
        $I->click('wp-submit');

        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/records');

        $I->waitForElement('.hrm-attendance-records-wrap', 10);
        $I->waitForElement('.hrm-punch-in-out-wrap', 10);

        $I->click('Punch In');
        $I->wait(5);
        $I->click('Punch Out');
        $I->click('#punch_in');
        $I->wait(2);
        $I->click('1');
        $I->click('#punch_out');
        $I->wait(2);
        $I->click('30');
        $I->click('Find');


        //employee attendance
        $I->wait(5);
        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/reports');
        $I->waitForElementNotVisible('.preloader');

        $I->click('.pm-datepickter-to');
        $I->wait(2);
        $I->click('1');
        $I->wait(2);
        $I->click('.pm-datepickter-from');
        $I->wait(2);
        $I->click('30');
        $I->click('Submit');
		$I->wait(1);
        $I->waitForElementNotVisible('.preloader');
        $I->wait(1);
        $I->scrollTo( ['css' => '.hrm-attendance-record-show-details'], 0, 0 );
        $I->wait(1);
        $I->click(['css' => '.hrm-attendance-record-show-details']);
        $I->wait(1);
        $I->scrollTo( ['css' => '.wp-list-table a'], 0, 0 );
        $I->wait(1);
        $I->click(['css' => '.wp-list-table a']);

       

        $I->wait(2);
    }

    public function admin_attendance() {
    	$I = $this->acceptanceTester;
    	//admin attendance
        $I->amOnPage('/wp-login.php');
        $I->wait(1);
        $I->fillField('log', 'admin');
        $I->fillField('pwd', 'admin');
        $I->click('wp-submit');

        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/records');
        $I->wait(1);
        $I->waitForElement('.hrm-date-picker-from');
        $I->wait(1);
        $I->click('.hrm-date-picker-from');
        $I->wait(1);
        $I->click('1');
        $I->wait(1);
        $I->click('.hrm-date-picker-to');
        $I->wait(1);
        $I->click('30');
        $I->wait(1);
        $I->selectOption( Locator::find( 'select', ['name' => 'user_id'] ), 'Employee Employee' );
        $I->click('Find');
        $I->waitForElementNotVisible('.preloader');
        $I->wait(3);

        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/attendance-customize');
        $I->click( '.page-title-action' );
        $I->click('.hrm-toggle');
        $I->wait(1);
        $this->multiselect( 2 );
        $I->wait(1);
        $I->click('.pm-datepickter-to');
        $I->wait(1);
        $I->click( date('d') );
        $I->wait(1);

        $I->fillField( '.customize-punch-in', date( 'Y-m-d 09:00:00', time() ) );
        $I->fillField( '.customize-punch-out', date( 'Y-m-d 17:00:00', time() ) );

        $I->click( 'Submit' );
        $I->wait(2);
        $this->multiselect( 2 );
        $I->click('.pm-datepickter-to');
        $I->wait(1);
        $I->click( '1' );
        $I->wait(1);
        $I->click('.pm-datepickter-from');
        $I->click( '30' );
        $I->wait(1);
        $I->click('Filter');


        //Edit
        $I->wait(2);
        $I->waitForElementVisible( ".hrm-tr", 30 );
        $I->moveMouseOver(['css' => '.hrm-tr:last-child']);
        $I->click( ['css' => 'tr.hrm-tr:last-child .hrm-edit-btn'] );
        $I->wait(2);
        $I->fillField( '.edit-date', date( 'Y-m-15', time() ) );
        $I->fillField( '.edit-punch-in', date( 'Y-m-15 17:00:00', time() ) );
        $I->fillField( '.edit-punch-out', date( 'Y-m-15 17:00:00', time() ) );

        $I->click( 'Update' );

        //Delete
        $I->wait(2);
        $I->waitForElement( ['css' => 'tr.hrm-tr:last-child .row-actions'], 30 );
        $I->moveMouseOver(['css' => 'tr.hrm-tr:last-child'] );
        $I->click(['css' => 'tr.hrm-tr:last-child .row-actions .hrm-delete-btn']);
        $I->wait(1);
        

        $I->wait(3);
    }

    public function admin_attendance_reports() {
        $I = $this->acceptanceTester;

        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/reports');

        $I->waitForElement( '.all-employee', 5 );
        $I->click( '.all-employee' );
        
        $I->click('.pm-datepickter-to');
        $I->wait(1);
        $I->click( '1' );
        $I->wait(1);
        $I->click('.pm-datepickter-from');
        $I->click( '30' );
        $I->wait(1);

        $I->click( 'Submit' );
        $I->wait( 5 );

        //repeat again for individual user
        $I->click( '.all-employee' );

        $I->wait(1);
        $this->multiselect( 2 );
        $I->click('.pm-datepickter-to');
        $I->wait(1);
        $I->click( '1' );
        $I->wait(1);
        $I->click('.pm-datepickter-from');
        $I->click( '30' );
        $I->wait(1);

        $I->click( 'Submit' );

        $I->wait(5);
    }

    public function configuration() {
        $I = $this->acceptanceTester;

        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/attendance-configuration');
        $I->waitForElement('.protected-ip');
        $I->fillField( '.protected-ip', '103.108.147.6|103.108.147.10|103.108.147.9');
        $I->wait(1);
        $I->click('Save changes');
        $I->wait(5);

        $I->fillField( '.protected-ip', '103.108.147.6|103.108.147.10|103.108.147.9');
        $I->click('Save changes');
        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/reports');
        $I->wait(1);
        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/attendance/attendance-configuration');

        $I->wait(500);
    }

}

