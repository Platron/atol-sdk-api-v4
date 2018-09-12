<?php

namespace Platron\Atol\handbooks;

use MyCLabs\Enum\Enum;

class PaymentTypes extends Enum
{
	const
		CASH = 0, // наличными
		ELECTRON = 1, // электронными
		PRE_PAID = 2, // предварительная оплата (аванс)
		CREDIT = 3, // последующая оплата (кредит)
		OTHER = 4,// иная форма оплаты (встречное предоставление
		ADDITIONAL = 5; // расширенный типы оплаты. для каждого фискального типа оплаты можно указать расширенный тип оплаты
}