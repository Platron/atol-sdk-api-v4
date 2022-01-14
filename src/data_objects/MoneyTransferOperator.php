<?php

namespace Platron\AtolV4\data_objects;

class MoneyTransferOperator extends BaseDataObject
{
	/** @var string */
	protected $name;
	/** @var int[] */
	private $phones;
	/** @var string */
	protected $address;
	/** @var int */
	protected $inn;

	/**
	 * MoneyTransferOperator constructor.
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = (string)$name;
	}

	/**
	 * @param int $phone
	 */
	public function addPhone($phone)
	{
		$this->phones[] = (string)$phone;
	}

	/**
	 * @param string $address
	 */
	public function addAddress($address)
	{
		$this->address = (string)$address;
	}

	/**
	 * @param int $inn
	 */
	public function addInn($inn)
	{
		$this->inn = (string)$inn;
	}
}