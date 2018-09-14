<?php

namespace Platron\Atol\clients;

use Platron\Atol\services\BaseServiceRequest;

interface iClient
{

	/**
	 * Послать запрос
	 * @param BaseServiceRequest $service
	 */
	public function sendRequest(BaseServiceRequest $service);
}
