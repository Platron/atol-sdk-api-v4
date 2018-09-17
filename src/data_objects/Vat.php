<?php

namespace Platron\Atol\data_objects;

use Platron\Atol\handbooks\Vates;

class Vat extends BaseDataObject
{
	/** @var string */
	protected $type;
	/** @var float */
	protected $sum;

	public function __construct(Vates $type)
	{
		$this->type = $type->getValue();
	}

	public function addSum($sum)
	{
		$this->sum = $this->getTaxAmount($sum);
	}

	/**
	 * Получить сумму налога
	 * @param float $amount
	 * @return float
	 */
	protected function getTaxAmount($amount)
	{
		switch ($this->type) {
			case Vates::NONE:
			case Vates::VAT0:
				return round(0, 2);
			case Vates::VAT10:
			case Vates::VAT110:
				return round($amount * 10 / 110, 2);
			case Vates::VAT18:
			case Vates::VAT118:
				return round($amount * 18 / 118, 2);
		}
	}
}