<?php

namespace Platron\AtolV4\tests\integration;

use Platron\AtolV4\clients\PostClient;
use Platron\AtolV4\data_objects\Company;
use Platron\AtolV4\data_objects\Correction;
use Platron\AtolV4\data_objects\CorrectionInfo;
use Platron\AtolV4\data_objects\Payment;
use Platron\AtolV4\data_objects\Vat;
use Platron\AtolV4\handbooks\CorrectionOperationTypes;
use Platron\AtolV4\handbooks\CorrectionTypes;
use Platron\AtolV4\handbooks\PaymentTypes;
use Platron\AtolV4\handbooks\SnoTypes;
use Platron\AtolV4\handbooks\Vates;
use Platron\AtolV4\SdkException;
use Platron\AtolV4\services\CreateCorrectionRequest;
use Platron\AtolV4\services\CreateReceiptResponse;
use Platron\AtolV4\services\GetTokenResponse;
use Platron\AtolV4\services\GetStatusResponse;
use Platron\AtolV4\services\GetStatusRequest;
use Platron\AtolV4\services\GetTokenRequest;

class CreateCorrectionTest extends IntegrationTestBase
{
	public function testCreateCorrection()
	{
		$client = new PostClient();
		$client->addLogger(new TestLogger());

		$tokenService = $this->createTokenRequest();
		$tokenResponse = new GetTokenResponse($client->sendRequest($tokenService));

		$this->assertTrue($tokenResponse->isValid());

		$createReceiptRequest = $this->createCorrectionRequest($tokenResponse->token);
		$createReceiptResponse = new CreateReceiptResponse($client->sendRequest($createReceiptRequest));

		$this->assertTrue($createReceiptResponse->isValid());

		$getStatusRequest = $this->createGetStatusRequest($createReceiptResponse, $tokenResponse);

		if(!$this->checkCorrectionStatus($client, $getStatusRequest)){
			$this->fail('Correction don`t change status');
		}
	}

	/**
	 * @param string $token
	 * @return CreateCorrectionRequest
	 */
	private function createCorrectionRequest($token)
	{
		$correction = $this->createCorrection();
		$externalId = time();
		$createCorrectionRequest = new CreateCorrectionRequest($token, $this->groupCode, $externalId, $correction);
		$createCorrectionRequest->setDemoMode();
		return $createCorrectionRequest;
	}

	/**
	 * @return GetTokenRequest
	 */
	private function createTokenRequest()
	{
		$tokenRequest = new GetTokenRequest($this->login, $this->password);
		$tokenRequest->setDemoMode();
		return $tokenRequest;
	}

	/**
	 * @param $createReceiptResponse
	 * @param $tokenResponse
	 * @return GetStatusRequest
	 */
	private function createGetStatusRequest($createReceiptResponse, $tokenResponse)
	{
		$getStatusRequest = new GetStatusRequest($this->groupCode, $createReceiptResponse->uuid, $tokenResponse->token);
		$getStatusRequest->setDemoMode();
		return $getStatusRequest;
	}

	/**
	 * @return Company
	 */
	private function createCompany()
	{
		$company = new Company(
			'test@test.ru',
			new SnoTypes(SnoTypes::ESN),
			$this->inn,
			$this->paymentAddress
		);
		return $company;
	}

	/**
	 * @return CorrectionInfo
	 */
	private function createCorrectionInfo()
	{
		$correctionInfo = new CorrectionInfo(
			new CorrectionTypes(CorrectionTypes::SELF),
			new \DateTime(),
			'Test base number',
			'Test base name'
		);
		return $correctionInfo;
	}

	/**
	 * @return Payment
	 */
	private function createPayment()
	{
		$payment = new Payment(
			new PaymentTypes(PaymentTypes::ELECTRON),
			100
		);
		return $payment;
	}

	/**
	 * @return Vat
	 */
	private function createVat()
	{
		$vat = new Vat(new Vates(Vates::VAT10));
		$vat->addSum(10);
		return $vat;
	}

	/**
	 * @return Correction
	 */
	private function createCorrection()
	{
		$company = $this->createCompany();
		$correctionInfo = $this->createCorrectionInfo();
		$payment = $this->createPayment();
		$vat = $this->createVat();

		$correction = new Correction(
			new CorrectionOperationTypes(CorrectionOperationTypes::BUY_CORRECTION),
			$company,
			$correctionInfo,
			$payment,
			$vat
		);
		return $correction;
	}

	/**
	 * @param PostClient $client
	 * @param GetStatusRequest $getStatusRequest
	 * @return bool
	 * @throws SdkException
	 */
	private function checkCorrectionStatus(PostClient $client, GetStatusRequest $getStatusRequest)
	{
		for ($second = 0; $second <= 10; $second++) {
			$getStatusResponse = new GetStatusResponse($client->sendRequest($getStatusRequest));
			if ($getStatusResponse->isReceiptReady()) {
				$this->assertTrue($getStatusResponse->isValid());
				return true;
			} else {
				$second++;
			}
			sleep(1);
		}
		return false;
	}
}