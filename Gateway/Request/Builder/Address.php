<?php

namespace Gg2\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\AddressAdapterInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

class Address implements BuilderInterface
{
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];
        $order = $paymentDataObject->getOrder();

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();
        $result = [
            'billTo' => $this->getFormattedAddress($billingAddress)
        ];

        if ($shippingAddress instanceof AddressAdapterInterface) {
            $result['shipTo'] = $this->getFormattedAddress($shippingAddress);
        }
        return $result;
    }

    private function getFormattedAddress(AddressAdapterInterface $address)
    {
        return [
            'firstName' => substr($address->getFirstname(), 0, 50),
            'lastName'  => substr($address->getLastname(), 0, 50),
            'company'   => substr(($address->getCompany() ?: ''), 0, 50),
            'address'   => substr(($address->getStreetLine1() . $address->getStreetLine2()), 0, 60),
            'city'      => substr($address->getCity(), 0, 40),
            'state'     => substr($address->getRegionCode(), 0, 40),
            'zip'       => substr($address->getPostcode(), 0, 20),
            'country'   => substr($address->getCountryId(), 0, 60)
        ];
    }

}
