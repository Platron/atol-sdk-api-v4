<?php

namespace Platron\Atol\handbooks;

use MyCLabs\Enum\Enum;

class ItemTypes extends Enum
{
	const
		RECEIPT = 'receipt', // Наименование параметра для передачи товаров при операциях прихода, расхода и возвратов
		CORRECTION = 'correction'; // Наименование параметра для передачи товаров при операциях коррекции прихода, расхода

	public static function getByOperationType(OperationTypes $operationType){
		switch($operationType->getValue()){
			case OperationTypes::SELL:
			case OperationTypes::BUY:
			case OperationTypes::BUY_REFUND:
			case OperationTypes::SELL_REFUND:
				return new self(self::RECEIPT);
			case OperationTypes::BUY_CORRECTION:
			case OperationTypes::SELL_CORRECTION:
			return new self(self::CORRECTION);
		}
	}
}