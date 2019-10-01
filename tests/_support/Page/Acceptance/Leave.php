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

    public function configuration() {
        $I = $this->acceptanceTester;

        $I->waitForElementVisible( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/dashboard'] ), 30 );
        $I->click( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/dashboard'] ) );
        $I->waitForElementVisible( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/leave'] ), 30 );
        $I->click( Locator::find( 'a', ['href' => 'admin.php?page=hr_management#/leave'] ) );
        $I->waitForElement( Locator::find( 'h2', ['class' => 'nav-tab-wrapper'] ), 30 );
        $I->click( 'Configuration' );
        $I->executeJS('window.scrollTo(0,0);');
        $I->click( Locator::find( 'a', ['class' => 'page-title-action hrm-btn'] ) );
        $I->waitForElement( '#hrm-leave-type-form', 30 );
        $I->waitForElement( '.multiselect__content-wrapper', 30 );
        $I->fillField('leave_type', $I->faker()->name);
        $I->fillField('entitlement', $I->faker()->randomDigit);
        $I->fillField('.multiselect__input', 'development');
        $I->fillField('.multiselect__input', '');
        $I->wait(3);
        $I->click('.multiselect__element');
        $I->click(Locator::find( 'input', ['type' => 'submit'] ));

       

     
        $I->wait(30);
    }

}
