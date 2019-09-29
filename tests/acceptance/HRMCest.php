<?php 

class HRMCest
{
	public $SigninCest;
	
    public function _before(AcceptanceTester $I)
    {
    	require_once dirname(__FILE__) . '/SigninCest.php';
    	$this->SigninCest = new SigninCest();
    }

    // tests
    public function hrm(AcceptanceTester $I)
    {
    	$this->SigninCest->loginSuccessfully($I);
    }
}
