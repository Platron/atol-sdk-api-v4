<?php

namespace Platron\AtolV4\tests\integration;

use PHPUnit\Framework\TestCase;

class IntegrationTestBase extends TestCase
{
	/** @var string */
	protected $login;
	/** @var string */
	protected $password;
	/** @var int */
	protected $inn;
	/** @var string */
	protected $groupCode;
	/** @var string */
	protected $paymentAddress;

	protected function setUp(): void
	{
		$this->login = MerchantSettings::LOGIN;
		$this->password = MerchantSettings::PASSWORD;
		$this->inn = MerchantSettings::INN;
		$this->groupCode = MerchantSettings::GROUP_ID;
		$this->paymentAddress = MerchantSettings::PAYMENT_ADDRESS;
	}
}
