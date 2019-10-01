<?php
namespace Step\Acceptance;

class Login extends \AcceptanceTester
{
	public function asAdmin() 
	{
		$I = $this;

        $I->amOnPage('/wp-login.php');
        $I->fillField('log', 'admin');
        $I->fillField('pwd', 'admin');
        $I->click('wp-submit');
	}

	public function hasElement($element)
	{
	    $I = $this;
	    try {
	        $I->seeElement( $element );
	        
	    } catch (\PHPUnit_Framework_AssertionFailedError $f) {
	        return false;
	    }
	    return true;
	}
}