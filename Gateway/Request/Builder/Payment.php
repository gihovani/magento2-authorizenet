<?php

namespace Gg2\Authorizenet\Gateway\Request\Builder;

use Gg2\Authorizenet\Observer\DataAssignObserver;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order\Payment as OrderPayment;

class Payment implements BuilderInterface
{
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        /** @var OrderPayment $payment */
        $payment = $paymentDataObject->getPayment();
        return [
            'payment' => [
                'creditCard' => [
                    'cardNumber'     => $payment->getData(DataAssignObserver::CC_NUMBER),
                    'expirationDate' => $this->getCardExpirationDate($payment),
                    'cardCode' => $payment->getData(DataAssignObserver::CC_CID)
                ]
            ]
        ];
    }

    private function getCardExpirationDate(OrderPayment $payment)
    {
        return sprintf(
            '%s-%s',
            $payment->getData(DataAssignObserver::CC_EXP_YEAR),
            $payment->getData(DataAssignObserver::CC_EXP_MONTH)
        );
    }
}
