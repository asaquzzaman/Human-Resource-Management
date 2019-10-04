<?php
namespace Page\Acceptance;
use \Codeception\Util\Locator;

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
        $this->configuration();
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

        // $I->waitForElementVisible( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/dashboard'] ), 30 );
        // $I->click( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/dashboard'] ) );
        // $I->waitForElementVisible( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/leave'] ), 30 );
        // $I->click( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/leave'] ) );
        // $I->waitForElement( Locator::find( 'h2', ['class' => 'nav-tab-wrapper'] ), 30 );
        // $I->click( 'Configuration' );
        
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
        $I->acceptPopup();

        

        $I->wait(30);
    }

}
