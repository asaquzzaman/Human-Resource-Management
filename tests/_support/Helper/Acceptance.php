<?php
namespace Helper;

use \Codeception\Util\Locator;
use Page\Acceptance\Leave;
use Step\Acceptance\Login;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

	public function faker() {
		return \Faker\Factory::create();
	}

	public function site_url() {
		return $this->getModule('WebDriver')->_getUrl();
	}

}
