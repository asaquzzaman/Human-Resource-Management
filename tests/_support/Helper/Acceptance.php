<?php
namespace Helper;

use \Codeception\Util\Locator;
use Page\Acceptance\Leave;
use Step\Acceptance\Login;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

	public function faker() 
	{
		return \Faker\Factory::create();
	}

	public function site_url() 
	{
		return $this->getModule('WebDriver')->_getUrl();
	}

	public function delete_cookies() {
		$this->getModule('WebDriver')->webDriver->manage()->deleteAllCookies();
	}

	public function hasElement( $tag, $element )
	{

	    try {
	        $this->getModule('WebDriver')->seeElement( Locator::find( $tag, $element ) );
	    } catch (\PHPUnit_Framework_AssertionFailedError $f) {
	        return false;
	    }
	    return true;
	}

}
