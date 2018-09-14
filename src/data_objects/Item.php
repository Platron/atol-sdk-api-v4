<?php

namespace Platron\Atol\data_objects;

use Platron\Atol\handbooks\PaymentMethods;
use Platron\Atol\handbooks\PaymentObjects;

class Item extends BaseDataObject
{

	/** @var float */
	protected $sum;
	/** @var Vat */
	protected $vat;
	/** @var string */
	protected $name;
	/** @var float */
	protected $price;
	/** @var int */
	protected $quantity;
	/** @var string */
	protected $measurement_unit;
	/** @var string */
	protected $payment_method;
	/** @var string */
	protected $payment_object;
	/** @var AgentInfo */
	protected $agent_info;
	/** @var string */
	protected $user_data;

	/**
	 * @param string $name Описание товара
	 * @param double $price Цена единицы товара
	 * @param float $quantity Количество товара
	 * @param Vat $vat
	 * @param double $sum Сумма количества товаров. Передается если количество * цену товара не равно sum
	 */
	public function __construct($name, $price, $quantity, Vat $vat, $sum = null)
	{
		$this->name = (string)$name;
		$this->price = (double)$price;
		$this->quantity = (double)$quantity;
		if (!$sum) {
			$this->sum = (double)$this->quantity * $this->price;
		} else {
			$this->sum = (double)$sum;
		}
		$this->vat = $vat;
	}

	/**
	 * Получить сумму позиции
	 * @return float
	 */
	public function getPositionSum()
	{
		return $this->sum;
	}

	/**
	 * @param string $measuringUnit
	 */
	public function addMeasurementUnit($measuringUnit)
	{
		$this->measurement_unit = (string)$measuringUnit;
	}

	/**
	 * @param PaymentMethods $paymentMethod
	 */
	public function addPaymentMethod(PaymentMethods $paymentMethod)
	{
		$this->payment_method = $paymentMethod->getValue();
	}

	/**
	 * @param PaymentObjects $paymentObject
	 */
	public function addPaymentObject(PaymentObjects $paymentObject)
	{
		$this->payment_object = $paymentObject->getValue();
	}

	/**
	 * @param AgentInfo $agentInfo
	 */
	public function addAgentInfo(AgentInfo $agentInfo)
	{
		$this->agent_info = $agentInfo;
	}

	/**
	 * @param string $userData
	 */
	public function addUserData($userData)
	{
		$this->user_data = (string)$userData;
	}
}
