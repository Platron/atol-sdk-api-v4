<?php

namespace Platron\Atol\data_objects;

use Platron\Atol\handbooks\OperationTypes;

class Receipt extends BaseDataObject
{
	/** @var Client */
	protected $client;
	/** @var Company */
	protected $company;
	/** @var Item[] */
	private $items;
	/** @var Payment[] */
	private $payments;
	/** @var string */
	private $operationType;

	/**
	 * Document constructor.
	 * @param Client $client
	 * @param Company $company
	 * @param Item $item
	 * @param Payment $payment
	 * @param OperationTypes $type
	 */
	public function __construct(Client $client, Company $company, Item $item, Payment $payment, OperationTypes $type)
	{
		$this->client = $client;
		$this->company = $company;
		$this->addItem($item);
		$this->addPayment($payment);
		$this->operationType = $type->getValue();
	}

	/**
	 * @param Item $item
	 */
	public function addItem(Item $item)
	{
		$this->items[] = $item;
	}

	/**
	 * @param Payment $payment
	 */
	public function addPayment(Payment $payment)
	{
		$this->payments[] = $payment;
	}

	/**
	 * @return float
	 */
	private function getItemsAmount()
	{
		$itemsAmount = 0;
		foreach ($this->items as $item) {
			$itemsAmount += $item->getPositionSum();
		}
		return $itemsAmount;
	}

	/**
	 * @return string
	 */
	public function getOperationType(){
		return $this->operationType;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		$params = parent::getParameters();

		foreach($this->items as $item) {
			$params['items'][] = $item->getParameters();
		}
		foreach($this->payments as $payment) {
			$params['payments'][] = $payment->getParameters();
		}

		$params['total'] = (double)$this->getItemsAmount();

		return $params;
	}
}