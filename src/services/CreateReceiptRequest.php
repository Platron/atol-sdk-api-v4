<?php

namespace Platron\Atol\services;

use Platron\Atol\data_objects\Receipt;

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
	 * @return array
	 */
	public function getParameters()
	{
		$params = parent::getParameters();
		$params['timestamp'] = date('d.m.Y H:i:s');
		return $params;
	}
}
