<?php

namespace Platron\AtolV4\data_objects;

use Platron\AtolV4\handbooks\AgentTypes;

class AgentInfo extends BaseDataObject
{
	/** @var string */
	protected $type;
	/** @var Supplier */
	private $supplier_info;
	/** @var PayingAgent */
	protected $paying_agent;
	/** @var ReceivePaymentsOperator */
	protected $receive_payments_operator;
	/** @var MoneyTransferOperator */
	protected $money_transfer_operator;

	public function __construct(AgentTypes $type, Supplier $supplier)
	{
		$this->type = $type->getValue();
		$this->supplier_info = $supplier;
	}

	/**
	 * @return Supplier
	 */
	public function getSupplierInfo()
	{
		return $this->supplier_info;
	}

	/**
	 * @param PayingAgent $payingAgent
	 */
	public function addPayingAgent(PayingAgent $payingAgent)
	{
		$this->paying_agent = $payingAgent;
	}

	/**
	 * @param ReceivePaymentsOperator $receivePaymentOperator
	 */
	public function addReceivePaymentsOperator(ReceivePaymentsOperator $receivePaymentOperator)
	{
		$this->receive_payments_operator = $receivePaymentOperator;
	}

	/**
	 * @param MoneyTransferOperator $moneyTransferOperator
	 */
	public function addMoneyTransferOperator(MoneyTransferOperator $moneyTransferOperator)
	{
		$this->money_transfer_operator = $moneyTransferOperator;
	}
}