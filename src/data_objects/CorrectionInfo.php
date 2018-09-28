<?php

namespace Platron\AtolV4\data_objects;

use Platron\AtolV4\handbooks\CorrectionTypes;

class CorrectionInfo extends BaseDataObject
{
	/** @var string */
	protected $type;
	/** @var string */
	protected $base_date;
	/** @var string */
	protected $base_number;
	/**	@var string */
	protected $base_name;

	public function __construct(CorrectionTypes $type, \DateTime $baseDate, $baseNumber, $baseName)
	{
		$this->type = $type->getValue();
		$this->base_date = $baseDate->format('d.m.Y');
		$this->base_number = (string)$baseNumber;
		$this->base_name = (string)$baseName;
	}
}