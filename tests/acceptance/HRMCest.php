<?php 
use \Codeception\Util\Locator;

class HRMCest
{
	public function _before(AcceptanceTester $I, \Step\Acceptance\Login $login)
    {
        
        
        $login->asAdmin();
        
    }

    public function allTest(AcceptanceTester $I, \Page\Acceptance\Leave $leave)
    {
        
        
    }
}

