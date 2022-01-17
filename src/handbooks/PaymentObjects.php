<?php

namespace Platron\AtolV4\handbooks;

use MyCLabs\Enum\Enum;

class PaymentObjects extends Enum
{
	const
		COMMODITY = 'commodity',
		EXCISE = 'excise',
		JOB = 'job',
		SERVICE = 'service',
		GAMBLING_BET = 'gambling_bet',
		GAMBLING_PRIZE = 'gambling_prize',
		LOTTERY = 'lottery',
		LOTTERY_PRIZE = 'lottery_prize',
		INTELLECTUAL_ACTIVITY = 'intellectual_activity',
		PAYMENT = 'payment',
		AGENT_COMMISSION = 'agent_commission',
		COMPOSITE = 'composite',
		ANOTHER = 'another',
		AWARD = 'award',
		DEPOSIT = 'deposit',
		EXPENSE = 'expense',
		PENSION_INSURANCE_IP = 'pension_insurance_ip',
		PENSION_INSURANCE = 'pension_insurance',
		MEDICAL_INSURANCE_IP = 'medical_insurance_ip',
		MEDICAL_INSURANCE = 'medical_insurance',
		SOCIAL_INSURANCE = 'social_insurance',
		CASINO_PAYMENT = 'casino_payment';
}
