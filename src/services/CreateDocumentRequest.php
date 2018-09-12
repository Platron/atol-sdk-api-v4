<?php

namespace Platron\Atol\services;

use Platron\Atol\data_objects\ReceiptPosition;
use Platron\Atol\handbooks\ItemTypes;
use Platron\Atol\handbooks\OperationTypes;
use Platron\Atol\handbooks\PaymentTypes;
use Platron\Atol\handbooks\SnoTypes;
use Platron\Atol\SdkException;

/**
 * Все парараметры обязательны для заполнения, кроме external_id. Он нужен только для корректировки чека. В наборе email|phone требуется хотя бы одно значение
 */
class CreateDocumentRequest extends BaseServiceRequest{
    
    /** @var string идентификатор группы ККТ */
    protected $groupCode;
    /** @var string тип операции */
    protected $operationType;
    /** @var string */
    protected $token;
    /** @var string */
    protected $paymentAddress;
    /** @var string */
    protected $customerEmail;
    /** @var int */
    protected $customerPhone;
    /** @var int */
    protected $inn;
    /** @var int */
    protected $paymentType;
    /** @var ReceiptPosition[] Позиции в чеке */
    protected $receiptPositions;
    /** @var string */
    protected $externalId;
    /** @var string */
    protected $sno;
    /** @var string */
    protected $callbackUrl = '';
    /** @var string */
    protected $itemsType;
        
    /**
     * @inheritdoc
     */
    public function getRequestUrl() {
        return self::REQUEST_URL.$this->groupCode.'/'.$this->operationType;
    }

    public function getHeaders()
	{
		return array_push(parent::getHeaders(), 'Token: '.$this->token);
	}

	/**
     * Добавить адрес магазина для оплаты (сайт)
     * @param string $address
     * @return CreateDocumentRequest
     */
    public function addMerchantAddress($address){
        $this->paymentAddress = $address;
        return $this;
    }
    
    /**
     * Установить email покупателя
     * @param string $email
     * @return CreateDocumentRequest
     */
    public function addCustomerEmail($email){
        $this->customerEmail = $email;
        return $this;
    }
    
    /**
     * Установить телефон покупателя
     * @param int $phone
     * @return CreateDocumentRequest
     */
    public function addCustomerPhone($phone){
        $this->customerPhone = $phone;
        return $this;
    }
    
    /**
     * Установить inn
     * @param int $inn
     * @return CreateDocumentRequest
     */
    public function addInn($inn){
        $this->inn = (string)$inn;
        return $this;
    }
    
    /**
     * Установить тип платежа. Из констант
     * @param PaymentTypes $paymentType
     * @return CreateDocumentRequest
     */
    public function addPaymentType(PaymentTypes $paymentType){
        $this->paymentType = $paymentType->getValue();
        return $this;
    }
    
    /**
     * Добавить позицию в чек
     * @param ReceiptPosition $position
     * @return CreateDocumentRequest
     */
    public function addReceiptPosition(ReceiptPosition $position){
        $this->receiptPositions[] = $position;
        return $this;
    }
    
    /**
     * Установить номер чека, если это коррекция
     * @param string $externalId
     * @return CreateDocumentRequest
     */
    public function addExternalId($externalId){
        $this->externalId = $externalId;
        return $this;
    }
    
    /**
     * Добавить SNO. Если у организации один тип - оно не обязательное. Из констант
     * @param SnoTypes $snoType
     * @return CreateDocumentRequest
     */
    public function addSno(SnoTypes $snoType){
        $this->sno = $snoType->getValue();
        return $this;
    }

    /**
     * @param string $token Токен из запроса получения токена
     * @return CreateDocumentRequest
     */
    public function __construct($token) {
        $this->token = $token;
        return $this;
    }
    
    /**
     * Добавить тип операции и определить наименование параметра для передачи товаров
     * @param OperationTypes $operationType Тип операции. Из констант
     * @return CreateDocumentRequest
     */
    public function addOperationType(OperationTypes $operationType){
        $this->operationType = $operationType->getValue();
		$this->itemsType = ItemTypes::getByOperationType($operationType)->getValue();
        return $this;
    }
    
    /**
     * Установить url для обратного запроса
     * @param type $url
     * @return CreateDocumentRequest
     */
    public function addCallbackUrl($url){
        $this->callbackUrl = $url;
        return $this;
    }
    
    /**
     * Добавить код группы
     * @param string $groupCode Идентификатор группы ККТ
     * @return CreateDocumentRequest
     */
    public function addGroupCode($groupCode){
        $this->groupCode = $groupCode;
        return $this;
    }
    
    public function getParameters() {        
        $totalAmount = 0;
        $items = [];
        foreach($this->receiptPositions as $receiptPosition){
            $totalAmount += $receiptPosition->getPositionSum();
            $items[] = $receiptPosition->getParameters();
        }

        $params = [
            'timestamp' => date('d.m.Y H:i:s'),
            'external_id' => $this->externalId,
            'service' => [
                'inn' => $this->inn,
                'callback_url' => $this->callbackUrl,
                'payment_address' => $this->paymentAddress,
            ],
            $this->itemsType => [
                'items' => $items,
                'total' => $totalAmount,
                'payments' => [
                    [
                        'sum' => $totalAmount,
                        'type' => $this->paymentType,
                    ],
                ],
                'attributes' => [
                    'sno' => $this->sno,
                ],
            ],
        ];
        
        /**
         * Отправлять надо только один контакт. Email предпочтительнее
         */
        if(!empty($this->customerEmail)){
            $params[$this->itemsType]['attributes']['email'] = $this->customerEmail;
            $params[$this->itemsType]['attributes']['phone'] = '';
        }
        elseif(!empty($this->customerPhone)){
            $params[$this->itemsType]['attributes']['phone'] = $this->customerPhone;
            $params[$this->itemsType]['attributes']['email'] = '';
        }
        
        return $params;
    }
}
