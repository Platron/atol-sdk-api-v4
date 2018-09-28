<?php

namespace Platron\AtolV4\services;

class GetStatusRequest extends BaseServiceRequest
{

	/** @var string */
	protected $groupCode;
	/** @var string */
	protected $uuId;
	/** @var string */
	protected $token;

	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() . $this->groupCode . '/report/' . $this->uuId;
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
	 * @param string $groupCode
	 * @param string $uuId
	 * @param string $token
	 */
	public function __construct($groupCode, $uuId, $token)
	{
		$this->groupCode = $groupCode;
		$this->uuId = $uuId;
		$this->token = $token;
	}

	public function getParameters()
	{
		return [];
	}
}
