<?php 

class SigninCest
{
    function _before(AcceptanceTester $I)
    {
    }
    
    public function _after(AcceptanceTester $I)
    {        
    }

    public function loginSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/wp-login.php');
		$I->fillField('log', 'admin');
		$I->fillField('pwd', 'admin');
		$I->click('wp-submit');
    }
}
