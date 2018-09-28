<?php

namespace Platron\AtolV4\services;

use Platron\AtolV4\data_objects\Correction;
use Platron\AtolV4\data_objects\Service;

class CreateCorrectionRequest extends BaseServiceRequest
{

	/** @var string идентификатор группы ККТ */
	private $groupCode;
	/** @var string */
	private $token;
	/** @var string */
	protected $external_id;
	/** @var Correction */
	protected $correction;
	/** @var Service */
	protected $service;

	/**
	 * CreateDocumentRequest constructor.
	 * @param string $token
	 * @param string $groupCode
	 * @param string $externalId
	 * @param Correction $correction
	 */
	public function __construct($token, $groupCode, $externalId, Correction $correction)
	{
		$this->token = (string)$token;
		$this->groupCode = $groupCode;
		$this->external_id = (string)$externalId;
		$this->correction = $correction;
	}

	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() . $this->groupCode . '/'.$this->correction->getOperationType();
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		$headers = parent::getHeaders();
		array_push($headers, 'Token: ' . $this->token);
		return $headers;
	}

	/**
	 * @param Service $service
	 */
	public function addService(Service $service)
	{
		$this->service = $service;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		$parameters = parent::getParameters();
		$parameters['timestamp'] = date('d.m.Y H:i:s');
		return $parameters;
	}
}