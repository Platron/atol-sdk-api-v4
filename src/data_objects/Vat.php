<?php

namespace Platron\AtolV4\data_objects;

use Platron\AtolV4\handbooks\Vates;

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
			case Vates::VAT5:
			case Vates::VAT105:
				return round($amount * 5 / 105, 2);
			case Vates::VAT7:
			case Vates::VAT107:
				return round($amount * 7 / 107, 2);
			case Vates::VAT10:
			case Vates::VAT110:
				return round($amount * 10 / 110, 2);
			case Vates::VAT20:
			case Vates::VAT120:
				return round($amount * 20 / 120, 2);
			case Vates::VAT22:
			case Vates::VAT122:
				return round($amount * 22 / 122, 2);
		}
	}
}