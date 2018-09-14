<?php

namespace Platron\Atol\services;

use stdClass;

abstract class BaseServiceResponse
{

	/** @var int */
	protected $errorCode;

	/** @var string */
	protected $errorDescription;

	public function __construct(stdClass $response)
	{
		if ($this->hasStandardError($response)) {
			$this->setStandardError($response);
		}

		foreach (get_object_vars($this) as $name => $value) {
			if (!empty($response->$name)) {
				$this->$name = $response->$name;
			}
		}
	}

	/**
	 * @param stdClass $response
	 * @return bool
	 */
	private function hasStandardError(stdClass $response)
	{
		return !empty($response->error->code);
	}

	/**
	 * @param stdClass $response
	 */
	private function setStandardError(stdClass $response)
	{
		$this->errorCode = $response->error->code;
		$this->errorDescription = 'Error type '.$response->error->text.' error_id '.$response->error->error_id.' '.$response->error->text;
	}

	/**
	 * Проверка на ошибки в ответе
	 * @return boolean
	 */
	public function isValid()
	{
		if (!empty($this->errorCode)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Получить код ошибки из ответа
	 * @return int
	 */
	public function getErrorCode()
	{
		return $this->errorCode;
	}

	/**
	 * Получить описание ошибки из ответа
	 * @return string
	 */
	public function getErrorDescription()
	{
		return $this->errorDescription;
	}
}
