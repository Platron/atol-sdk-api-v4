<?php

namespace Platron\AtolV4\data_objects;


class Service extends BaseDataObject
{
	/** @var string */
	protected $callbackUrl;

	public function __construct($callbackUrl)
	{
		$this->callbackUrl = (string)$callbackUrl;
	}
}