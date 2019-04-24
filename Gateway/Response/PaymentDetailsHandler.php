<?php

namespace Gg2\Authorizenet\Gateway\Response;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Model\InfoInterface;

class PaymentDetailsHandler implements HandlerInterface
{

    private $additionalInformation = [
        ResponseFields::AUTH_CODE        => 'auth_code',
        ResponseFields::AVS_RESULT_CODE  => 'avs_result_code',
        ResponseFields::CVV_RESULT_CODE  => 'cvv_result_code',
        ResponseFields::CAVV_RESULT_CODE => 'cavv_result_code',
        ResponseFields::ACCOUNT_NUMBER   => 'account_number',
        ResponseFields::ACCOUNT_TYPE     => 'account_type',
        ResponseFields::TEST_REQUEST     => 'test_request'
    ];

    public function handle(array $handlingSubject, array $response)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $handlingSubject['payment'];

        /** @var InfoInterface $payment */
        $payment = $paymentDataObject->getPayment();

        $transactionResponse = $response[ResponseFields::TRANSACTION_RESPONSE];
        foreach ($this->additionalInformation as $responseKey => $paymentKey) {
            if (isset($transactionResponse[$responseKey]) && !empty($transactionResponse[$responseKey])) {
                $payment->setAdditionalInformation($paymentKey, $transactionResponse[$responseKey]);
            }
        }
    }
}
