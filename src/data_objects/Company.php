<?php

namespace Platron\Atol\data_objects;

use Platron\Atol\handbooks\SnoTypes;

class Company extends BaseDataObject
{
	/** @var string */
	protected $email;
	/** @var string */
	protected $sno;
	/** @var int */
	protected $inn;
	/** @var string */
	protected $payment_address;

	public function __construct($email, SnoTypes $sno, $inn, $paymentAddress)
	{
		$this->email = (string)$email;
		$this->sno = $sno->getValue();
		$this->inn = (string)$inn;
		$this->payment_address = (string)$paymentAddress;
	}
}