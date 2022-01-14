<?php

namespace Platron\AtolV4\services;

use Platron\AtolV4\data_objects\Receipt;
use Platron\AtolV4\data_objects\Service;

class CreateReceiptRequest extends BaseServiceRequest
{

	/** @var string идентификатор группы ККТ */
	private $groupCode;
	/** @var string */
	private $token;
	/** @var string */
	protected $external_id;
	/** @var Receipt */
	protected $receipt;
	/** @var Service */
	protected $service;

	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() . $this->groupCode . '/'.$this->receipt->getOperationType();
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
	 * CreateDocumentRequest constructor.
	 * @param string $token
	 * @param string $groupCode
	 * @param string $externalId
	 * @param Receipt $receipt
	 */
	public function __construct($token, $groupCode, $externalId, Receipt $receipt)
	{
		$this->token = (string)$token;
		$this->groupCode = $groupCode;
		$this->external_id = (string)$externalId;
		$this->receipt = $receipt;
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
		$params = parent::getParameters();
		$params['timestamp'] = date('d.m.Y H:i:s');
		return $params;
	}
}
