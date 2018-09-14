<?php

namespace Platron\Atol\data_objects;


class Service extends BaseDataObject
{
	/** @var string */
	protected $callbackUrl;

	public function __construct($callbackUrl)
	{
		$this->callbackUrl = (string)$callbackUrl;
	}
}