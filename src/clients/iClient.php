<?php

namespace Platron\AtolV4\clients;

use Platron\AtolV4\services\BaseServiceRequest;

interface iClient
{

	/**
	 * Послать запрос
	 * @param BaseServiceRequest $service
	 * @return stdClass
	 */
	public function sendRequest(BaseServiceRequest $service);
}
