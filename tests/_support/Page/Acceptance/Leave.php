<?php
namespace Page\Acceptance;
use \Codeception\Util\Locator;
use \Codeception\Util\ActionSequence;


class Leave 
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

        $this->configuration();
        $I->wait(2);
        $this->leave();
        $I->wait(2);
        $this->requested_leave();

        $I->wait(2);

    }

    public function holiday() {
        $I = $this->acceptanceTester;
        
        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/leave-configuration/holidays' );

        //Create
        $I->click( Locator::find( 'a', ['class' => 'page-title-action hrm-btn'] ) );
        $I->wait(1);
        $I->fillField(Locator::find( 'input', ['name' => 'name'] ), $I->faker()->name);
        $I->click( Locator::find( 'input', ['name' => 'from'] ));
        $I->waitForElement( '.ui-datepicker-calendar', 10 );
        $I->click( 10 );
        $I->waitForElementNotVisible('.ui-datepicker-calendar');
        $I->click( Locator::find( 'input', ['name' => 'to'] ));
        $I->waitForElement( '.ui-datepicker-calendar', 10 );
        $I->click( 15 );
        $I->fillField('.holiday-description', $I->faker()->text);
        $I->click( 'Save changes' );

        //Edit
        $I->wait(2);
        $I->waitForElementVisible( ".hrm-tr", 30 );
        $I->moveMouseOver(['css' => '.hrm-tr:last-child']);
        $I->click( ['css' => 'tr.hrm-tr:last-child .holiday-edit-btn'] );
        $I->waitForElementVisible( "//input[@name = 'post_title']", 30 );
        $I->fillField(Locator::find( 'input', ['name' => 'post_title'] ), $I->faker()->name);
        $I->fillField('.holiday-description', $I->faker()->text);
        $I->click( 'Submit' );

        //Delete
        $I->wait(2);
        $I->waitForElement( ['css' => 'tr.hrm-tr:last-child .row-actions'], 30 );
        $I->moveMouseOver(['css' => 'tr.hrm-tr:last-child'] );
        $I->click(['css' => 'tr.hrm-tr:last-child .row-actions .hrm-delete-btn']);
        $I->wait(1);
        $I->acceptPopup();

    }

    public function leave() {
        $I = $this->acceptanceTester;
        
        $I->amOnPage('/wp-login.php');
        $I->wait(1);
        $I->fillField('log', 'employee');
        $I->fillField('pwd', 'admin');
        $I->click('wp-submit');

        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/records' );

        //Create
        $I->waitForElement( '.page-title-action', 10);
        $I->wait(1);
        $I->click( Locator::find( 'a', ['class' => 'page-title-action hrm-btn'] ) );
        $I->wait(1);
        $I->waitForElementNotVisible('.preloader');
        $this->multiselect(2);
        $I->fillField('.leave-description', $I->faker()->text);

       
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-11' ) . "']"] );
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-12' ) . "']"] ); 
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-13' ) . "']"] );
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-14' ) . "']"] );
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-15' ) . "']"] );
        $I->click( ['css' => ".fc-content-skeleton td[data-date='" . date( 'Y-m-16' ) . "']"] );      

        
        $I->click('Save changes');
    }

    public function requested_leave() {
        $I = $this->acceptanceTester;

        $I->amOnPage('/wp-login.php');
        $I->wait(1);
        $I->fillField('log', 'admin');
        $I->fillField('pwd', 'admin');
        $I->click('wp-submit');

        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/leave-request/pending' );

        $I->waitForElement( ['css' => 'tr.leave-action-tr:first-child .approve'], 10);
        $I->click( ['css' => 'tr.leave-action-tr:first-child .approve']);
        $I->wait(2);
        $I->click( ['css' => 'tr.leave-action-tr:nth-child(2) .cancel']);
        $I->wait(2);
        $I->click( ['css' => 'tr.leave-action-tr:nth-child(3) .cancel']);
        $I->wait(2);
        $I->click( ['css' => 'tr.leave-action-tr:nth-child(4) .delete']);
        $I->wait(2);
        $I->acceptPopup();
        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/leave-request/approve' );
        $I->wait(3);
        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/leave-request/cancel' );
        $I->waitForElement( ['css' => 'tr.leave-action-tr:first-child .restore'], 10);
        $I->click( ['css' => 'tr.leave-action-tr:first-child .restore']);
        $I->wait(2);
        $I->click( ['css' => 'tr.leave-action-tr:first-child .delete']);
        $I->wait(1);
        $I->acceptPopup();
    }

    public function multiselect( $number ) {
        $I = $this->acceptanceTester;

        $I->click('.multiselect__select');
        $I->waitForElement( '.multiselect__element', 30 );
        $element = Locator::find( 'li', ['class' => 'multiselect__element'] );
        $I->click(Locator::elementAt( $element, $number ));
    }

    public function lastElement( $tag, $clas, $number = false ) {
        $I = $this->acceptanceTester;

        $element = Locator::find( $tag, ['class' => $clas] );

        if ( $number === false ) {
            return Locator::lastElement( $element );
        } 
        
        return Locator::elementAt( $element, $number );
    }

    public function configuration() {
        $I = $this->acceptanceTester;
        $this->type();
        $I->wait(2);
        $this->work_week();
        $I->wait(2);
        $this->holiday();
        $I->wait(2);
        $this->settings();
    }

    public function type() {
        $I = $this->acceptanceTester;
        
        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/records/' );
        $I->executeJS('window.scrollTo(0,0);');
        $I->click( 'Configuration' );
        $I->click( Locator::find( 'a', ['class' => 'page-title-action hrm-btn'] ) );
        $I->waitForElement( '#hrm-leave-type-form', 30 );
        $I->waitForElement( '.multiselect__content-wrapper', 30 );
        $I->fillField('leave_type', $I->faker()->name);
        $this->multiselect(1);
        $I->fillField('entitlement', $I->faker()->randomDigitNot(0));
        //$this->multiselect(2);
        $I->click(Locator::find( 'input', ['id'=>'hrm-next-year'] ));
        $I->click(Locator::find( 'input', ['type' => 'submit'] ));

        //Edit
        $I->waitForElementNotVisible('.hrm-slide-up');
        $I->moveMouseOver(['css' => 'tr.hrm-tr:last-child'] );
        $I->click( $this->lastElement( 'a', 'leave-type-edit-btn' ) );
        //$I->wait(1);
        $I->waitForElementVisible( "//input[@name = 'post_title']", 30 );
        
        $I->fillField('post_title', $I->faker()->name);
        $I->click('.ptitle');
        $this->multiselect(2);
        //$this->multiselect(3);
        $I->click('submit');
        $I->waitForElement( ['css' => 'tr.hrm-tr:last-child .row-actions'], 30 );
        $I->moveMouseOver(['css' => 'tr.hrm-tr:last-child'] );
        $I->click(['css' => 'tr.hrm-tr:last-child .row-actions .leave-type-delete-btn']);
        $I->wait(1);
        $I->acceptPopup();
    }

    public function work_week() {
        $I = $this->acceptanceTester;
        
        $I->amOnPage('/wp-admin/admin.php?page=hr_management#/leave/leave-configuration/work-week');
        $I->waitForElement( '.hrm-attendance-configuration', 10 );
        $I->wait(2);
        $I->selectOption( Locator::find( 'select', ['name' => 'saturday'] ), 'Non-Working Day' );
        $I->selectOption( Locator::find( 'select', ['name' => 'sunday'] ), 'Non-Working Day' );
        
    }

    public function settings() {
        $I = $this->acceptanceTester;
        
        $I->amOnPage( '/wp-admin/admin.php?page=hr_management#/leave/leave-configuration/form' );
        $this->multiselect(1);
        $I->wait(1);
        $this->multiselect(2);
        $I->click( 'Save changes' );
        $I->wait(2);
        $this->multiselect(1);
        $I->click( 'Save changes' );
    }

}
