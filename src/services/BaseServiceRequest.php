<?php

namespace Platron\Atol\services;

use Platron\Atol\data_objects\BaseDataObject;

abstract class BaseServiceRequest extends BaseDataObject
{
	/** @var bool */
	private $demoMode;

	const
		REQUEST_URL = 'https://online.atol.ru/possystem/v4/',
		REQUEST_DEMO_URL = 'https://testonline.atol.ru/possystem/v4/';

	/**
	 * Получить url ждя запроса
	 * @return string
	 */
	abstract public function getRequestUrl();

	/**
	 * @return string
	 */
	protected function getBaseUrl()
	{
		return $this->demoMode ? self::REQUEST_DEMO_URL : self::REQUEST_URL;
	}

	public function setDemoMode()
	{
		$this->demoMode = true;
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return [
			'Content-type: application/json; charset=utf-8'
		];
	}
}
