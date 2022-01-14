<?php

namespace Platron\AtolV4\data_objects;

use Platron\AtolV4\handbooks\CorrectionOperationTypes;

class Correction extends BaseDataObject
{
	/** @var Company */
	protected $company;
	/** @var CorrectionInfo */
	protected $correction_info;
	/** @var Payment[] */
	private $payments;
	/** @var Vat */
	private $vats;
	/** @var CorrectionOperationTypes */
	private $operationType;

	/**
	 * Correction constructor.
	 * @param CorrectionOperationTypes $operationType
	 * @param Company $company
	 * @param CorrectionInfo $correctionInfo
	 * @param Payment $payment
	 * @param Vat $vat
	 */
	public function __construct(CorrectionOperationTypes $operationType, Company $company, CorrectionInfo $correctionInfo, Payment $payment, Vat $vat)
	{
		$this->operationType = $operationType->getValue();
		$this->company = $company;
		$this->correction_info = $correctionInfo;
		$this->addPayment($payment);
		$this->addVat($vat);
	}

	/**
	 * @param Payment $payment
	 */
	public function addPayment(Payment $payment)
	{
		$this->payments[] = $payment;
	}

	/**
	 * @param Vat $vat
	 */
	public function addVat(Vat $vat)
	{
		$this->vats[] = $vat;
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
		$parameters = parent::getParameters();
		foreach($this->payments as $payment){
			$parameters['payments'][] = $payment->getParameters();
		}
		foreach($this->vats as $vat){
			$parameters['vats'][] = $vat->getParameters();
		}

		return $parameters;
	}
}