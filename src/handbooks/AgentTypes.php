<?php

namespace Platron\Atol\handbooks;

use MyCLabs\Enum\Enum;

class AgentTypes extends Enum
{
	const
		BANK_PAYING_AGENT = 'bank_paying_agent',
		BANK_PAYING_SUB_AGENT = 'bank_paying_subagent',
		PAYING_AGENT = 'paying_agent',
		PAYING_SUB_AGENT = 'paying_subagent',
		ATTORNEY = 'attorney',
		COMMISSION_AGENT = 'commission_agent',
		ANOTHER = 'another';

}