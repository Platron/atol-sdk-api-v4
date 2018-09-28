<?php

namespace Platron\AtolV4\data_objects;

class ReceivePaymentsOperator extends BaseDataObject
{
	/** @var int[] */
	protected $phones;

	/**
	 * ReceivePaymentsOperator constructor.
	 * @param int $phone
	 */
	public function __construct($phone)
	{
		$this->phones[] = (string)$phone;
	}

	/**
	 * @param int $phone
	 */
	public function addPhone($phone)
	{
		$this->phones[] = (string)$phone;
	}
}