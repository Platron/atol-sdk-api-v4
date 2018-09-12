<?php

namespace Platron\Atol\handbooks;

use MyCLabs\Enum\Enum;

class SnoTypes extends Enum
{
	const
		OSN = 'osn', // общая СН
		USN_INCOME = 'usn_income', // упрощенная СН (доходы)
		USN_INCOME_OUTCOME = 'usn_income_outcome', // упрощенная СН (доходы минус расходы)
		ENDV = 'envd', // единый налог на вмененный доход
		ESN = 'esn', // единый сельскохозяйственный налог
		PATENT = 'patent'; // патентная СН
}