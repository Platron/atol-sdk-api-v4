<?php

namespace Platron\Atol\services;

class CreateReceiptResponse extends BaseServiceResponse
{
	/** @var string Уникальный идентификатор */
	public $uuid;

	/** @var string */
	public $status;
}
