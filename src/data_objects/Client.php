<?php

namespace Platron\AtolV4\data_objects;

class Client extends BaseDataObject
{
	protected $phone;
	protected $email;

	/**
	 * @param string $email
	 */
	public function addEmail($email)
	{
		$this->email = (string)$email;
	}

	/**
	 * @param int $phone
	 */
	public function addPhone($phone)
	{
		$this->phone = (string)$phone;
	}
}