<?php

namespace Platron\Atol\handbooks;

use MyCLabs\Enum\Enum;

class OperationTypes extends Enum
{
	const
		SELL = 'sell', // Приход
		SELL_REFUND = 'sell_refund', // Возврат прихода
		SELL_CORRECTION = 'sell_correction', // Коррекция прихода
		BUY = 'buy', // Расход
		BUY_REFUND = 'buy_refund', // Возврат расхода
		BUY_CORRECTION = 'buy_correction'; // Коррекция расхода
}