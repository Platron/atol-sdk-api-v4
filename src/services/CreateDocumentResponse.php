<?php

namespace Platron\Atol\services;

abstract class CreateDocumentResponse extends BaseServiceResponse
{
	/** @var string Уникальный идентификатор */
	public $uuid;

	/** @var string */
	public $status;
}