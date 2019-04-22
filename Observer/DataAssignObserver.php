<?php

namespace Gg2\Authorizenet\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Model\Quote\Payment;

class DataAssignObserver extends AbstractDataAssignObserver
{

    const CC_NUMBER = 'cc_number';
    const CC_TYPE_4 = 'cc_last_4';
    const CC_TYPE = 'cc_type';
    const CC_EXP_MONTH = 'cc_exp_month';
    const CC_EXP_YEAR = 'cc_exp_year';
    const CC_CID = 'cc_cid';

    private $paymentsFields = [
        self::CC_NUMBER    => 'cc_number',
        self::CC_TYPE_4    => 'cc_last_4',
        self::CC_TYPE      => 'cc_type',
        self::CC_EXP_MONTH => 'cc_exp_month',
        self::CC_EXP_YEAR  => 'cc_exp_year',
        self::CC_CID       => 'cc_cid'
    ];

    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);

        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }

        /** @var Payment $paymentInfo */
        $paymentInfo = $this->readPaymentModelArgument($observer);
        foreach ($this->paymentsFields as $field => $formField) {
            if (isset($additionalData[$formField])) {
                $paymentInfo->setData($field, $additionalData[$formField]);
            }
        }
    }
}
