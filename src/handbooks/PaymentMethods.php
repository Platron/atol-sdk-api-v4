<?php

namespace Platron\AtolV4\handbooks;

use MyCLabs\Enum\Enum;

class PaymentMethods extends Enum
{
	const
		FULL_PREPAYMENT = 'full_prepayment',
		PREPAYMENT = 'prepayment',
		ADVANCE = 'advance',
		FULL_PAYMENT = 'full_payment',
		PARTIAL_PAYMENT = 'partial_payment',
		CREDIT = 'credit',
		CREDIT_PAYMENT = 'credit_payment';
}