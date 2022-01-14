<?php

namespace Platron\AtolV4\data_objects;

class Client extends BaseDataObject
{
	protected $phone;
	protected $email;
	protected $name;
	protected $inn;

	/**
	 * @param string $email
	 */
	public function addEmail($email)
	{
		$this->email = (string)$email;
	}

	/**
	 * @param int $phone Номер телефона в международном формате
	 */
	public function addPhone($phone)
	{
		$this->phone = '+'.(string)$phone;
	}

	/**
	 * @param string $name
	 */
	public function addName($name)
	{
		$this->name = (string)$name;
	}

	/**
	 * @param int $inn
	 */
	public function addInn($inn)
	{
		$this->inn = (string)$inn;
	}
}