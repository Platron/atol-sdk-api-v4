<?php

namespace Platron\Atol\clients;

use Platron\Atol\services\BaseServiceRequest;

interface iClient
{

	/**
	 * Послать запрос
	 * @param BaseServiceRequest $service
	 * @return stdClass
	 */
	public function sendRequest(BaseServiceRequest $service);
}
