<?php

namespace Platron\AtolV4\tests\integration;

use Platron\AtolV4\clients\PostClient;
use Platron\AtolV4\data_objects\AgentInfo;
use Platron\AtolV4\data_objects\Client;
use Platron\AtolV4\data_objects\Company;
use Platron\AtolV4\data_objects\Item;
use Platron\AtolV4\data_objects\MoneyTransferOperator;
use Platron\AtolV4\data_objects\PayingAgent;
use Platron\AtolV4\data_objects\Payment;
use Platron\AtolV4\data_objects\Receipt;
use Platron\AtolV4\data_objects\ReceivePaymentsOperator;
use Platron\AtolV4\data_objects\Supplier;
use Platron\AtolV4\data_objects\Vat;
use Platron\AtolV4\handbooks\AgentTypes;
use Platron\AtolV4\handbooks\ReceiptOperationTypes;
use Platron\AtolV4\handbooks\PaymentMethods;
use Platron\AtolV4\handbooks\PaymentObjects;
use Platron\AtolV4\handbooks\PaymentTypes;
use Platron\AtolV4\handbooks\SnoTypes;
use Platron\AtolV4\handbooks\Vates;
use Platron\AtolV4\SdkException;
use Platron\AtolV4\services\CreateReceiptRequest;
use Platron\AtolV4\services\CreateReceiptResponse;
use Platron\AtolV4\services\GetStatusResponse;
use Platron\AtolV4\services\GetTokenResponse;
use Platron\AtolV4\services\GetStatusRequest;
use Platron\AtolV4\services\GetTokenRequest;

class CreateReceiptTest extends IntegrationTestBase
{
	public function testCreateReceipt()
	{
		$client = new PostClient();
		$client->addLogger(new TestLogger());

		$tokenService = $this->createTokenRequest();
		$tokenResponse = new GetTokenResponse($client->sendRequest($tokenService));

		$this->assertTrue($tokenResponse->isValid());

		$createReceiptRequest = $this->createReceiptRequest($tokenResponse->token);
		$createReceiptResponse = new CreateReceiptResponse($client->sendRequest($createReceiptRequest));

		$this->assertTrue($createReceiptResponse->isValid());

		$getStatusRequest = $this->createGetStatusRequest($createReceiptResponse, $tokenResponse);
		if(!$this->checkReceiptStatus($client, $getStatusRequest)){
			$this->fail('Receipt don`t change status');
		}
	}

	/**
	 * @return Client
	 */
	private function createCustomer()
	{
		$customer = new Client();
		$customer->addEmail('test@test.ru');
		$customer->addPhone('79050000000');
		return $customer;
	}

	/**
	 * @return Company
	 */
	private function createCompany()
	{
		$company = new Company(
			'company@test.ru',
			new SnoTypes(SnoTypes::ESN),
			$this->inn,
			$this->paymentAddress
		);
		return $company;
	}

	/**
	 * @return Vat
	 */
	private function createVat()
	{
		$vat = new Vat(new Vates(Vates::VAT10));
		$vat->addSum(20);
		return $vat;
	}

	/**
	 * @return Supplier
	 */
	private function createSupplier()
	{
		$supplier = new Supplier('Supplier name');
		$supplier->addInn($this->inn);
		$supplier->addPhone('79050000001');
		$supplier->addPhone('79050000002');
		return $supplier;
	}

	/**
	 * @return PayingAgent
	 */
	private function createPayingAgent()
	{
		$payingAgent = new PayingAgent('Operation name');
		$payingAgent->addPhone('79050000003');
		$payingAgent->addPhone('79050000004');
		return $payingAgent;
	}

	/**
	 * @return MoneyTransferOperator
	 */
	private function createMoneyTransferOperator()
	{
		$moneyTransferOperator = new MoneyTransferOperator('Test moneyTransfer operator');
		$moneyTransferOperator->addInn($this->inn);
		$moneyTransferOperator->addPhone('79050000005');
		$moneyTransferOperator->addAddress('site.ru');
		return $moneyTransferOperator;
	}

	/**
	 * @return ReceivePaymentsOperator
	 */
	private function createReceivePaymentOperator()
	{
		$receivePaymentOperator = new ReceivePaymentsOperator('79050000006');
		$receivePaymentOperator->addPhone('79050000007');
		return $receivePaymentOperator;
	}

	/**
	 * @return AgentInfo
	 */
	private function createAgentInfo()
	{
		$supplier = $this->createSupplier();
		$agentInfo = new AgentInfo(
			new AgentTypes(AgentTypes::PAYING_AGENT),
			$supplier
		);

		$payingAgent = $this->createPayingAgent();
		$agentInfo->addPayingAgent($payingAgent);
		$moneyTransferOperator = $this->createMoneyTransferOperator();
		$receivePaymentOperator = $this->createReceivePaymentOperator();

		$agentInfo->addMoneyTransferOperator($moneyTransferOperator);
		$agentInfo->addReceivePaymentsOperator($receivePaymentOperator);

		return $agentInfo;
	}

	/**
	 * @return Item
	 */
	private function createItem()
	{
		$vat = $this->createVat();
		$item = new Item(
			'Test Product',
			10,
			2,
			$vat
		);
		$agentInfo = $this->createAgentInfo();
		$item->addAgentInfo($agentInfo);
		$item->getPositionSum(20);
		$item->addMeasurementUnit('pounds');
		$item->addPaymentMethod(new PaymentMethods(PaymentMethods::FULL_PAYMENT));
		$item->addPaymentObject(new PaymentObjects(PaymentObjects::COMMODITY));
		$item->addUserData('Test user data');
        $item->addExcise(5.64);
        $item->addCountryCode("643");
        $item->addDeclarationNumber("10702020/060520/0013422");
		return $item;
	}

	/**
	 * @return Payment
	 */
	private function createPayment()
	{
		$payment = new Payment(
			new PaymentTypes(PaymentTypes::ELECTRON),
			20
		);
		return $payment;
	}

	/**
	 * @return Receipt
	 */
	private function createReceipt()
	{
		$item = $this->createItem();
		$payment = $this->createPayment();
		$customer = $this->createCustomer();
		$company = $this->createCompany();
		$receipt = new Receipt($customer, $company, [$item], $payment, new ReceiptOperationTypes(ReceiptOperationTypes::BUY));
		return $receipt;
	}

	/**
	 * @param string $token
	 * @return CreateReceiptRequest
	 */
	private function createReceiptRequest($token)
	{
		$receipt = $this->createReceipt();
		$externalId = time();
		$createReceiptRequest = new CreateReceiptRequest(
			$token,
			$this->groupCode,
			$externalId,
			$receipt
		);
		$createReceiptRequest->setDemoMode();
		return $createReceiptRequest;
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
	 * @param PostClient $client
	 * @param GetStatusRequest $getStatusRequest
	 * @return bool
	 * @throws SdkException
	 */
	private function checkReceiptStatus(PostClient $client, GetStatusRequest $getStatusRequest)
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
