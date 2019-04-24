<?php

namespace Gg2\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order;

class Totals implements BuilderInterface
{
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];
        $payment = $paymentDataObject->getPayment();
        $order = $paymentDataObject->getOrder();
        /** @var Order $orderModel */
        $orderModel = $payment->getOrder();

        return [
            'tax'      => [
                'amount' => $orderModel->getBaseTaxAmount()
            ],
            'duty'     => [
                'amount' => 0
            ],
            'shipping' => [
                'amount' => $orderModel->getBaseShippingAmount(),
                'name'   => substr($orderModel->getShippingMethod(), 0, 31)
            ],
            'poNumber' => $order->getOrderIncrementId()
        ];
    }
}
